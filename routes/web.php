<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SupplierTypeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectScopeTemplateController;
use App\Http\Controllers\CostPlanController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SectionItemController;
use App\Http\Controllers\VariationOrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TemplateSection;
use App\Http\Controllers\TemplateItem;


use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
    
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

    Route::resource('clients', ClientController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('supplier-types', SupplierTypeController::class);
    Route::resource('project-scope-templates', ProjectScopeTemplateController::class);
    Route::resource('costPlans', CostPlanController::class);
    Route::resource('sections', SectionController::class);
    Route::resource('section_items', SectionItemController::class);
    Route::resource('variation-orders', VariationOrderController::class);
    Route::get('section_items/{section_item?}/edit', [SectionItemController::class, 'edit'])
    ->name('section_items.edit');

    // Route::get('/projects/{id}/edit', [ProjectController::class, 'edit'])
    // ->name('projects.edit');

    Route::group(["prefix" => "projects", "as" => "projects."], function(){
        Route::get('/index', [ProjectController::class, 'index'])->name("index");
        Route::get('/create', [ProjectController::class, 'create'])->name("create");
        Route::get('/edit/{tab?}/{project_id?}', [ProjectController::class, 'edit']);
        Route::post('/', [ProjectController::class, 'upsertProject'])
            ->name('store');
        Route::put('/{id}', [ProjectController::class, 'upsertProject'])
            ->name('update');
         Route::post('/costplan_store', [ProjectController::class, 'upsertCostPlan'])
            ->name('costplan_store');
         Route::put('/costplan_update/{id}', [ProjectController::class, 'upsertCostPlan'])
            ->name('costplan_update');
    });

    

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    
});

require __DIR__.'/auth.php';
