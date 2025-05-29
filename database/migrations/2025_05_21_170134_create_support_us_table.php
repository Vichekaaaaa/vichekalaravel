<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('support_us', function (Blueprint $table) {
            $table->id();
            $table->string('section')->index(); // e.g., 'intro', 'donate', 'sponsor', 'share', 'thank_you'
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->json('buttons')->nullable(); // Store button text and URLs as JSON
            $table->integer('order')->default(0); // For sorting sections
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('support_us');
    }
};