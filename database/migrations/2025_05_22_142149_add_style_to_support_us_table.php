<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStyleToSupportUsTable extends Migration
{
    public function up()
    {
        Schema::table('support_us', function (Blueprint $table) {
            $table->string('style')->default('style1')->after('order');
        });
    }

    public function down()
    {
        Schema::table('support_us', function (Blueprint $table) {
            $table->dropColumn('style');
        });
    }
}