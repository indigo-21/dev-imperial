<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CostPlanSection;
use App\Models\CostPlanItem;
use Illuminate\Database\Eloquent\Casts\Json;

class CostPlanController extends Controller
{
    public function index()
    {
        return view('pages.costPlans.index');
    }

    public function create()
    {
        return view('pages.costPlans.form');
    }

    public function upsert(Request $request){
        $result = true;
        $project_id = $request->project_id;
        $sections = $request->sections;
        $is_create = false;
        
        foreach ($sections as $key => $section) {
            $costplan_section_id = $section["section_id"];
            $is_create = !$costplan_section_id;
            $cost_plan_section = $costplan_section_id ?  CostPlanSection::find($costplan_section_id) : new CostPlanSection();
            $cost_plan_section->project_id = $project_id;
            $cost_plan_section->section_code = $section["section_code"];
            $cost_plan_section->section_name = $section["section_name"];
            $cost_plan_section->mark_up = $section["section_markup"];
            $result = $cost_plan_section->save();

            if($result && count($section["items"]) > 0){
              foreach ($section["items"] as $key => $item) {
                    $costplan_item_id = $item["item_id"];
                    $cost_plan_item = $costplan_item_id ? CostPlanItem::find($costplan_item_id): new CostPlanItem();
                    $cost_plan_item->cost_plan_section_id  = $cost_plan_section->id;
                    $cost_plan_item->item_code  = $item["item_code"];
                    $cost_plan_item->description  = $item["description"];
                    $cost_plan_item->quantity  = $item["quantity"];
                    $cost_plan_item->mark_up  = $item["mark_up"];
                    $cost_plan_item->unit  = $item["unit"];
                    $cost_plan_item->rate  = $item["rate"] != "" ? $item["rate"] : null ;
                    $cost_plan_item->cost  = $item["cost"];
                    $cost_plan_item->total  = $item["total"];
                    $cost_plan_item->supplier_id  = $item["supplier_id"];
                    $result = $cost_plan_item->save() ? true : false;
              }
            }



        }

        $project_reference = "PRJ-" . str_pad($project_id, 5, '0', STR_PAD_LEFT);
        $message = !$is_create ? $project_reference." Update Successfully" : "New Costplan created on ".$project_reference; 
        return Json::encode(["success" => $result, "message" => $message]);
    }

}
