<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectScopeTemplateController;
use App\Http\Controllers\CostPlanController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SectionItemController;
use App\Http\Controllers\VariationOrderController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
    
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

    Route::resource('projects', ProjectController::class);
    Route::resource('project-scope-templates', ProjectScopeTemplateController::class);
    Route::resource('costPlans', CostPlanController::class);
    Route::resource('sections', SectionController::class);
    Route::resource('section_items', SectionItemController::class);
    Route::resource('variation-orders', VariationOrderController::class);
    Route::get('section_items/{section_item?}/edit', [SectionItemController::class, 'edit'])
    ->name('section_items.edit');
    

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
