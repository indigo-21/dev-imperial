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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('business_name')->nullable();
            $table->string('business_address')->nullable();
            $table->string('unique_tax_reference')->nullable();
            $table->string('company_registration_number')->nullable();
            $table->string('cis_rate')->nullable();
            $table->string('vat_number')->nullable();
            $table->string('supplier_types')->nullable();
            $table->bigInteger('pli_cover_value')->nullable();
            $table->date('insurance_policy_expiry')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
