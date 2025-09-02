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
            $table->string('slug');
            $table->string('nik');
            $table->string('phone');
            $table->text('address');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            $table->foreignId('internet_package_id')->constrained()->onDelete('restrict');

            $table->softDeletes();
            $table->timestamps();

            // agar tidak ada lagi 
            $table->unique('user_id');
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
