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
        Schema::create('notification_logs', function (Blueprint $table) {
            $table->id();
            $table->string('target_type'); // all, region, user
            $table->unsignedBigInteger('target_id')->nullable(); // Bisa ID User atau ID Region
            $table->string('category'); // general, installation_update
            $table->string('title');
            $table->text('body');
            $table->json('data_payload')->nullable();
            $table->integer('total_sent')->default(0);
            $table->foreignId('sent_by')->constrained('users'); // Admin yang kirim
            $table->timestamps();
            $table->softDeletes();
            $table->index(['created_at', 'target_type']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_logs');
    }
};
