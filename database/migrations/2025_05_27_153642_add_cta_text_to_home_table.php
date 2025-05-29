<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCtaTextToHomeTable extends Migration
{
    public function up()
    {
        Schema::table('home', function (Blueprint $table) {
            $table->text('cta_text')->nullable()->after('bio'); // Add cta_text column after bio
        });
    }

    public function down()
    {
        Schema::table('home', function (Blueprint $table) {
            $table->dropColumn('cta_text'); // Drop the column if rolling back
        });
    }
}