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
        Schema::create('cost_plan_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cost_plan_section_id')->constrained('cost_plan_sections')->cascadeOnDelete();
            $table->string('item_code')->nullable();
            $table->string('description');
            $table->float('quantity', 2)->nullable();
            $table->float('mark_up', 2)->nullable();
            $table->string('unit')->nullable();
            $table->float('rate', 2)->nullable();
            $table->float('cost', 2)->nullable();
            $table->float('total', 2)->nullable();
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cost_plan_items');
    }
};
