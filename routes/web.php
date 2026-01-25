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
use App\Models\CostPlanSection;
use App\Http\Controllers\CostPlanSectionController;
use App\Models\CostPlanItem;
use App\Http\Controllers\CostPlanItemController;
use App\Models\PurchaseOrderItem;
use App\Http\Controllers\PurchaseOrderItemController;
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
        Route::get('/', [ProjectController::class, 'index'])
            ->name("index");
        Route::get('/edit/{tab?}/{project_id?}', [ProjectController::class, 'edit']);
        Route::get('/create', [ProjectController::class, 'create'])
            ->name("create");
        Route::post('/', [ProjectController::class, 'upsertProject'])
            ->name('store');
        Route::put('/{id}', [ProjectController::class, 'upsertProject'])
            ->name('update');
         Route::post('/costplan_store', [ProjectController::class, 'upsertCostPlan'])
            ->name('costplan_store');
         Route::put('/costplan_update/{id}', [ProjectController::class, 'upsertCostPlan'])
            ->name('costplan_update');
        Route::put('/project_file_upsert/{id}', [ProjectController::class, 'upsertProjectFile'])
            ->name('project_file_upsert');
        Route::delete('/project_file_destroy/{id}', [ProjectController::class, 'destroyProjectFile'])
            ->name('project_file_destroy');
        Route::post('/purchase_order_upsert', [ProjectController::class, 'upsertPurchaseOrder'])
            ->name('purchase_order_upsert');
    });

    Route::post('/get_items_by_supplier', [CostPlanItemController::class, 'getItemsBySupplier'])
            ->name('get_items_by_supplier');
    Route::post('/get_po_item', [PurchaseOrderItemController::class, 'getPurchaseOrderItems'])
            ->name('get_po_item');

    

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    
});

require __DIR__.'/auth.php';
