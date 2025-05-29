<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIconColumnToSupportUsTable extends Migration
{
    public function up()
    {
        Schema::table('support_us', function (Blueprint $table) {
            $table->string('icon')->nullable()->after('buttons'); // Add icon column after buttons
        });
    }

    public function down()
    {
        Schema::table('support_us', function (Blueprint $table) {
            $table->dropColumn('icon');
        });
    }
}