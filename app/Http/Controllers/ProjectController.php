<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\TemplateItem;
use App\Models\TemplateSection;
use App\Models\Supplier;
use App\Models\ProjectType;
use App\Http\Controllers\Controller;
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
            "templateSections" => TemplateSection::with('items')->get(),
            "suppliers" =>  Supplier::orderBy('business_name')->get(),
            "project_types" => $project_types,

        ];

        if ($type == "form") {

            $result += ["statuses" => $statuses];

            if ($id) {
                $result += [
                    "project"   => Project::findOrFail($id)
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
        // dd($request);
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
}
