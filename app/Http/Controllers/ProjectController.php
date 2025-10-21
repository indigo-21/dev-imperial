<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
   public function index()
    {
        return view('pages.projects.index');
    }

    public function create()
    {
        return view('pages.projects.form');
    }

    public function edit(string $id)
    {
        return view('pages.projects.edit');
    }
}
