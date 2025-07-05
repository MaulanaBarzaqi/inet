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
        Schema::create('internet_packages', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug');
            $table->string('category');
            $table->string('speed');
            $table->string('ideal_device');
            $table->unsignedBigInteger('installation');
            $table->unsignedBigInteger('monthly_bill');
            $table->string('image')->nullable();
            
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internet_packages');
    }
};
