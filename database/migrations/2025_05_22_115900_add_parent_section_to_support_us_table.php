<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddParentSectionToSupportUsTable extends Migration
{
    public function up()
    {
        Schema::table('support_us', function (Blueprint $table) {
            $table->string('parent_section')->nullable()->after('section');
        });
    }

    public function down()
    {
        Schema::table('support_us', function (Blueprint $table) {
            $table->dropColumn('parent_section');
        });
    }
}