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
        Schema::create('internet_installations', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('nik');
            $table->string('phone');
            $table->string('address');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->integer('user_id'); 
            $table->integer('internet_package_id');
            
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internet_installations');
    }
};
