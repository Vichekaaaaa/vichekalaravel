<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCtaBioToHomeTable extends Migration // Use a standard name like this
{
    public function up()
    {
        Schema::table('home', function (Blueprint $table) {
            $table->text('cta_bio')->nullable()->after('cta_text');
        });
    }

    public function down()
    {
        Schema::table('home', function (Blueprint $table) {
            $table->dropColumn('cta_bio');
        });
    }
}