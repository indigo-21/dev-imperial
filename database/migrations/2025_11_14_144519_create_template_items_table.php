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
        Schema::create('template_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_section_id')->constrained();
            $table->string('item_code');
            $table->text('description');
            $table->integer('quantity');
            $table->string('unit', 50);
            $table->decimal('rate', 15, 2);
            $table->integer('mark_up');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('template_items');
    }
};
