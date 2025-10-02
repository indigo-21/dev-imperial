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
         // permissions
        //   Schema::create('permissions', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name');
        //     $table->boolean('can_view')->nullable(); 
        //     $table->boolean('can_create')->nullable(); 
        //     $table->boolean('can_edit')->nullable(); 
        //     $table->boolean('can_delete')->nullable(); 
        //     $table->boolean('can_download')->nullable(); 
        //     $table->timestamps();
        //     $table->softDeletes();
        // });

         // user_types
          Schema::create('user_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->foreignId('user_type_id')->constrained();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('created_by')->nullable()->constrained("users");
            $table->foreignId('updated_by')->nullable()->constrained("users");
            $table->foreignId('deleted_by')->nullable()->constrained("users");
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_types');
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
