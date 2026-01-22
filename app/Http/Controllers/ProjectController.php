<?php

namespace App\Http\Controllers;

use App\Models\TemplateItem;
use App\Models\TemplateSection;
use App\Models\Supplier;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
   public function default_data($type = "index", $id = false){
        $tabs = [
            "project-detail",
            "project-files",
            "cost-plan",
            "variation-order",
            "adjudication"
        ];
        $project_types   = [
                "CAT A",
                "CAT A+",
                "CAT B",
                "Small Works",
                "Refurbishment",
                "Reconfiguration",
                "Day 2 Works",
                "Dilapidation",
                "Design Only",
                "Furniture Only"
        ];

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

        $project = (object) [
                'id' => 1,
                'project_description' => 'Office refurbishment and workspace redesign for head office.',
                'project_reference' => 'PRJ-001',
                'client_id' => 2,
                'project_type' => 'CAT A',
                'project_size' => 15000,
                'client_budget' => 2500000.00,
                'lead_source' => 'Architect Referral',
                'lead_owner' => 'James Carter',
                'project_director' => 'Emily Carter',
                'status' => 'Pre-construction',
                'designer' => 'BrightSpace Studio',
                'high_risk_building' => true,
                'referral_fee' => 5.0,
                ];

        $result = [
                "tabs" => $tabs,
                "templateSections" => TemplateSection::with('items')->get(), 
                "suppliers" =>  Supplier::orderBy('business_name')->get(),
                "project_types" => $project_types,
                
        ];

        if($type == "form"){
            
            $result += ["statuses"=>$statuses];

            if($id){
                $result += [
                    "project"   => $project
                ];
            }
        }
        
        return $result;
   }

   public function index()
    {
        return view('pages.projects.index');
    }

    public function create()
    {
        $data = self::default_data("form");
        return view('pages.projects.tabs.project-detail' , $data);
    }

    public function edit($tab = "project-detail", $id)
    {
        $data = self::default_data("form" , $id);
        $view = "pages.projects.tabs.$tab";

        if (!view()->exists($view))
        {
            return redirect("projects/edit/project-detail/$id");
            return  view("pages.projects.tabs.project-detail", $data);
        }
        return view($view, $data);
    }
}
