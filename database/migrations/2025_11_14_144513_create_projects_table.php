<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('description')->nullable();
            $table->string('reference')->nullable();
            $table->foreignId('project_type_id')->constrained('project_types')->cascadeOnDelete();
            $table->float('client_budget', 2)->nullable();
            $table->string('lead_owner')->nullable();
            $table->string('pre_construction')->nullable();
            $table->boolean('high_risk_building')->default(false);
            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();
            $table->float('size', 2)->nullable();
            $table->string('lead_source')->nullable();
            $table->string('project_director')->nullable();
            $table->string('designer')->nullable();
            $table->float('referral_fee', 2)->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
