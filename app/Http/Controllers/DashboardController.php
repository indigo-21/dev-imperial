<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Project;
use App\Models\Supplier;
use App\Models\Client;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
    
        $projects = Project::count();
        $suppliers = Supplier::count();
        $clients = Client::count();
        $users = User::count();

        return view('pages.dashboard', compact(
            'projects',
            'suppliers',
            'clients',
            'users'
        ));
    }
}
