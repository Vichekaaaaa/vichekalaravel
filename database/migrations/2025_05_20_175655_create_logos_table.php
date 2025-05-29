<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('logos', function (Blueprint $table) {
            $table->id();
            $table->longtext('image_data')->nullable(); // Use longtext to handle large base64 strings
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logos');
    }
};