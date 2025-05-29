<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('NY Vicheka');
            $table->json('roles'); // Store roles like ["UI/UX Designer", "Web Developer", "Freelancer"]
            $table->json('stats'); // Store stats like [{"number": "50+", "label": "Projects"}, ...]
            $table->json('social_links'); // Store social links like [{"platform": "Facebook", "url": "#", "icon": "..."}, ...]
            $table->text('bio')->nullable(); // Bio for the description
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home');
    }
};