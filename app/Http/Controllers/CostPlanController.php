<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

}
