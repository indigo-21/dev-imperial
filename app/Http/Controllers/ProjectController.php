<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\CostPlanSection;
use App\Models\TemplateItem;
use App\Models\TemplateSection;
use App\Models\Supplier;
use App\Models\ProjectType;
use App\Http\Controllers\Controller;
use App\Models\CostPlanItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function default_data($type = "index", $id = false)
    {
        $tabs = [
            "project-detail",
            "project-files",
            "cost-plan",
            "variation-order",
            "adjudication"
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

        $result = [
            "tabs" => $tabs,
            "suppliers" =>  Supplier::orderBy('business_name')->get(),
            "project_types" => $project_types,

        ];

        if ($type == "form") {
            $has_cost_plan = CostPlanSection::where("project_id", $id)->get();
            $result += [
                        "statuses" => $statuses,
                        "cost_plan" => TemplateSection::with('items')->get(),
                        ];

            if ($id) {
                if($has_cost_plan){
                    $result["cost_plan"] = "";
                    $result["cost_plan"] = $has_cost_plan ? CostPlanSection::where("project_id", $id)->get() : TemplateSection::with('items')->get();
                }
                $result += [
                    "project"   => Project::findOrFail($id),
                    "has_cost_plan" => CostPlanSection::where("project_id", $id)->get()
                ];
            }
        }else{
            $result += ["projects" => Project::all()];
        }

        return $result;
    }

    public function index()
    {
        $data = self::default_data();
        return view('pages.projects.index', $data);
    }

    public function create()
    {
        $data = self::default_data("form");
        return view('pages.projects.tabs.project-detail', $data);
    }

    public function edit($tab = "project-detail", $id)
    {
        $data = self::default_data("form", $id);
        $view = "pages.projects.tabs.$tab";

        if (!view()->exists($view)) {
            return redirect("projects/edit/project-detail/$id");
            // return  view("pages.projects.tabs.project-detail", $data);
        }
      
        return view($view, $data);
    }

    public function upsertProject(Request $request, $id = false)
    {
        $project = !$id ? new Project : Project::findOrFail($id);

        $project->description = $request->project_description;
        $project->project_type_id = $request->project_type;
        $project->client_budget = $request->client_budget;
        $project->lead_owner = $request->lead_owner;
        $project->project_status = $request->project_status;
        $project->high_risk_building = $request->high_risk_building ? 1 : 0;
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
        // dd($data);
        // return view("pages.projects.tabs.project-detail", $data);
        return redirect("projects/edit/project-detail/$project->id");
    }

    public function upsertCostPlan(Request $request, $id = false){
        // dd($request);
        $project_id = $request->project_id;
        $section_codes = $request->section_code;
        $section_names = $request->section_name;
        $section_markups = $request->section_markup;
        $section_data = [];

        for ($i=0; $i < count($section_codes); $i++) { 
            $items = $request->item_code[$i];
            $cost_plan_section = new CostPlanSection();
            $cost_plan_section->project_id = $project_id;
            $cost_plan_section->section_code = $section_codes[$i];
            $cost_plan_section->section_name = $section_names[$i];
            $cost_plan_section->mark_up = $section_markups[$i];
            $cost_plan_section->save();
            $cost_plan_section_id = $cost_plan_section->id;
            

            for ($j=0; $j < count($items) ; $j++) {
                $cost_plan_item = new CostPlanItem();
                $item_code = $request?->item_code[$i][$j] ?? null;
                $description = $request?->description[$i][$j] ?? null;
                $quantity = $request?->quantity[$i][$j] ?? null;
                $unit = $request?->unit[$i][$j] ?? null;
                $rate = $request?->rate[$i][$j] ?? null;
                $cost = $request?->cost[$i][$j] ?? null;
                $total = $request?->total[$i][$j] ?? null;
                $mark_up = $request?->mark_up[$i][$j] ?? null;

                $cost_plan_item->cost_plan_section_id  = $cost_plan_section_id;
                $cost_plan_item->item_code  = $item_code;
                $cost_plan_item->description  = $description;
                $cost_plan_item->quantity  = $quantity;
                $cost_plan_item->mark_up  = $mark_up;
                $cost_plan_item->unit  = $unit;
                $cost_plan_item->rate  = $rate != "" ? $rate : null ;
                $cost_plan_item->cost  = $cost;
                $cost_plan_item->total  = $total;
                $cost_plan_item->supplier_id  = 1;

                $result = $cost_plan_item->save();
                
            }
            
            
        }

        return redirect("projects/edit/cost-plan/$project_id");
    }
}
