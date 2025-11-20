<?php

namespace App\Http\Controllers;

use App\Models\TemplateItem;
use App\Models\TemplateSection;
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
       $templateSections = TemplateSection::with('items')->get();

       return view('pages.projects.edit', compact('templateSections'));
    }
}
