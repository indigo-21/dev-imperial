<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\CostPlanSection;
use App\Models\TemplateItem;
use App\Models\TemplateSection;
use App\Models\Supplier;
use App\Models\ProjectType;
use App\Models\Client;
use App\Models\ProjectFile;
use App\Http\Controllers\Controller;
use App\Models\CostPlanItem;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Casts\Json;

class ProjectController extends Controller
{
    public function default_data($type = "index", $id = false){
        // $tabs = [
        //     "project-detail",
        //     "project-files",
        //     "cost-plan",
        //     "variation-order",
        //     "adjudication",
        //     "purchase-orders"
        // ];
        $tabs = [
            "project-detail",
            "project-files",
            "cost-plan",
            // "variation-order",
            // "adjudication",
            // "purchase-orders"
        ];

        $project_types   = ProjectType::all();

        $statuses = [
            'New Lead',
            'Qualification',
            'Meeting Stage',
            'Design Stage',
            'Costing Stage',
            'Pitch/Presentation Stage',
            'Awaiting Decision',
            'Won',
            'On Hold',
            'Lost',
            'Pre-Construction Stage',
            'Construction Stage',
            'After Care',
        ];
        
        $units = [
            'sqm',
            'LM',
            'item',
            'no',
            'p. sum',
            'weeks',
            'note',
        ];

        $result = [
            "clients" => Client::all(),
            "suppliers" =>  Supplier::orderBy('business_name')->get(),
            "project_types" => $project_types,
        ];

        if ($type == "form") {
            $has_cost_plan = CostPlanSection::where("project_id", $id)->count();
            $result += [
                        "units" => $units,
                        "statuses" => $statuses,
                        "cost_plan" => TemplateSection::with('items')->get(),
                        "has_costplan" => false
                        ];

            if ($id) {
                if($has_cost_plan){
                    // array_push($tabs,"variation-order");
                    $cost_plan_sections = CostPlanSection::where("project_id", $id);
                    $cost_plan_section_ids = [];
                    foreach ($cost_plan_sections->get() as $key => $cost_plan_section) {
                        array_push($cost_plan_section_ids, $cost_plan_section->id);
                    }
                    $for_po_suppliers = CostPlanItem::whereIn("cost_plan_section_id", $cost_plan_section_ids)
                                                    ->join('suppliers', 'suppliers.id', '=', 'cost_plan_items.supplier_id')
                                                    ->select('supplier_id', DB::raw('MIN(suppliers.business_name) as business_name'))
                                                    ->groupBy('supplier_id')
                                                    ->orderBy("business_name",'asc')
                                                    ->get();
                    
                    if($for_po_suppliers->count()){
                        array_push($tabs,"purchase-orders");
                        array_push($tabs,"adjudication");
                        // dd($tabs);
                    }

                    $result["cost_plan"] = "";
                    $result["has_costplan"] = true;
                    $result["cost_plan"] = $cost_plan_sections->get();
                    $result["for_po_suppliers"] = $for_po_suppliers; 
                    $result["purchase_orders"] = PurchaseOrder::where("project_id", $id)->get();
                    
                }
                $result += [
                    "project"   => Project::findOrFail($id),
                    "has_cost_plan" => CostPlanSection::where("project_id", $id)->get(),
                    "project_files" => ProjectFile::where("project_id",$id)->get()
                ];

                
                
            }
        }else{
            $result += ["projects" => Project::all()];
        }
        $result["tabs"] = $tabs;
        return $result;
    }

    public function form_rule($type= "project-detail", $id = false){
        switch ($type) {
            case 'cost-plan':
                return [
                    "section_markup.*" => ["required"],
                    "item_code.*" => ["required"],
                    "quantity.*" => ["required"],
                    "unit.*" => ["required"],
                    "rate.*" => ["required"],
                    "cost.*" => ["required"],
                    "total.*" => ["required"],
                    "mark_up.*" => ["required"],

                ];
                break;
            
            default:
                # project-detail
                return [
                        "project_description" => ["required", "string","min:2"],
                        "client_id" => ["required"],
                        "project_type" => ["required"],
                        "project_status" => ["required"],
                        "high_risk_building" => ["required"],
                ];
                break;
        }
    }

    public function change_field_name(){
        return [
                "project_description" => "Project Description",
                "client_id" => "Client",
                "project_type" => "Project Type",
                "project_status" => "Project Status",
        ];
    }

    public function index(){
        $data = self::default_data();
        return view('pages.projects.index', $data);

        // return view('pages.projects.pdf-purchase-order', $data);
    }

    public function create(){
        $data = self::default_data("form");
        return view('pages.projects.tabs.project-detail', $data);
    }

    public function edit($tab = "project-detail", $id){
        $data = self::default_data("form", $id);
        $view = "pages.projects.tabs.$tab";

        if (!view()->exists($view)) {
            return redirect("projects/edit/project-detail/$id");
            // return  view("pages.projects.tabs.project-detail", $data);
        }
      
        return view($view, $data);
    }

    public function upsertProject(Request $request, $id = false){
        $request->validate(self::form_rule("project-detail", $id),[], self::change_field_name());

        $project = !$id ? new Project : Project::findOrFail($id);

        $project->description = $request->project_description;
        $project->project_type_id = $request->project_type;
        $project->client_budget = $request->client_budget;
        $project->lead_owner = $request->lead_owner;
        $project->project_status = $request->project_status;
        $project->high_risk_building = $request->high_risk_building;
        $project->client_id = $request->client_id;
        $project->size = $request->project_size;
        $project->lead_source = $request->lead_source;
        $project->project_director = $request->project_director;
        $project->designer = $request->designer;
        $project->referral_fee = $request->referral_fee;

        $project->{$id ? "updated_by" : "created_by"} = Auth::id();
        $data = self::default_data("form", $id);
        $result = $project->save();
        $message = "Error: Project table issue";
        if ($result) {
            $project_reference = "PRJ-" . str_pad($project->id, 5, '0', STR_PAD_LEFT);
            $message = $project_reference;
        }
        $success_message = ["success" => $result, "message" => $message];
        $data += $success_message;
        return redirect("projects/edit/project-detail/$project->id")->with("success", $success_message["message"]);
    }

    public function upsertProjectFile(Request $request, $project_id){
            
        
        $request->validate([
            // "project_id" => ["required"],
            // "file" => ["required", "file"],
            "description" => ["required"],
            ]);
        // dd($request->validate([
        //     "project_id" => ["required"],
        //     "file" => ["required", "file"],
        //     "description" => ["required"],
        //     ]));

        $project_file_id = $request->project_file_id;
        $project_file = !$project_file_id ? new ProjectFile() : ProjectFile::findOrFail($project_file_id);
        if($request->file("file")){
            $file = $request->file("file");
            $filename = time()."_".$file->getClientOriginalName();
            // $path = $file->storeAs("public/uploads", $filename);
            $path = $file->storeAs('uploads', $filename, 'public');
            $project_file->filename = $filename;
        }

        $project_file->project_id = $project_id;
        $project_file->description = $request->description;
        $project_file->{!$project_file_id ? "created_by" : "updated_by"} = Auth::id();

        if($project_file->save()){
            return redirect("projects/edit/project-files/$project_id")->with("success", "File Upload Successfully ".$project_file->description);
        }else{
            return redirect("projects/edit/project-files/$project_id")->with("error", "No file selected.");
        }
    }

    public function destroyProjectFile($id){
        $project_file = ProjectFile::findOrFail($id);
        $project_id = $project_file->project_id ;
        $filename = $project_file->filename;
        $project_file->deleted_by = Auth::id();
        $project_file->save();
        $project_file->delete();
        return redirect("projects/edit/project-files/$project_id")->with("success", $filename." deleted successfully ");
    }
    
    public function upsertPurchaseOrder(Request $request){
        // dd($request);
        $project_id = $request->project_id;
        $supplier_id = $request->supplier_id;
        $purchase_order_id = $request->purchase_order_id;
        $item_data = [];
        $exist_purchase_order_items = [];
        
        $purchase_order = !$purchase_order_id ? new PurchaseOrder() : PurchaseOrder::findOrFail($purchase_order_id);
        $purchase_order->project_id = $project_id;
        $purchase_order->supplier_id = $supplier_id;
        $purchase_order->{$purchase_order_id ? "updated_by":"created_by"} = Auth::id();
        $purchase_order->save();
        $purchase_order_id = $purchase_order->id;

        $purchase_order_items = PurchaseOrderItem::where("purchase_order_id", $purchase_order_id);

        if($purchase_order_items->count()){
            foreach ($purchase_order_items->get() as $key => $item) {
                array_push($exist_purchase_order_items, $item->id);  
            }
        }

        for ($i=0; $i < count($request->item_code) ; $i++) { 
            $total = floatval($request?->quantity[$i] ?? 0) * floatval($request?->unit_price[$i] ?? 0);
            $items = [
                    "purchase_order_id" => $purchase_order_id,
                    "section_code" => $request->section_code[$i],
                    "cost_plan_section_id" => $request->cost_plan_section_id[$i],
                    "item_code" => $request->item_code[$i],
                    "description" => $request->item_description[$i],
                    "quantity" => $request->quantity[$i],
                    "unit_price" => $request->unit_price[$i],
                    "total" => $total,
                ];  
            array_push($item_data, $items);
        }

        $purchase_order_item_result = DB::table("purchase_order_items")
                                                ->insert($item_data);
        if($purchase_order_item_result){
            PurchaseOrderItem::whereIn("id", $exist_purchase_order_items)->delete();
        }   
        
        $po_number = "PO-" . str_pad($purchase_order_id, 5, '0', STR_PAD_LEFT);
        $message = count($exist_purchase_order_items) ? $po_number." Update Successfully" : "New Purchase Order ".$po_number; 
        return redirect("projects/edit/purchase-orders/$project_id")->with("success", $message);

    }

    public function viewItemFromAdjudication($id){
        $cost_plan_item = CostPlanItem::findOrFail($id);
        return response()->json($cost_plan_item);
    }
    


}
