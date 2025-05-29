<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('home', function (Blueprint $table) {
            $table->json('buttons')->nullable()->after('social_links');
        });
    }

    public function down(): void
    {
        Schema::table('home', function (Blueprint $table) {
            $table->dropColumn('buttons');
        });
    }
};