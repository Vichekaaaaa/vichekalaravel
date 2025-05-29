<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactMethodsTable extends Migration
{
    public function up()
    {
        Schema::create('contact_methods', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // e.g., "Call Us", "Twitter"
            $table->string('icon')->nullable(); // e.g., "fa-phone", "fa-twitter"
            $table->string('url')->nullable(); // e.g., "tel:+1234567890", "https://twitter.com/yourhandle"
            $table->string('phone_number')->nullable(); // e.g., "+1234567890"
            $table->string('type'); // e.g., "phone", "social", "email"
            $table->timestamps();
        });

        // Drop the old contacts table since it's no longer needed
        Schema::dropIfExists('contacts');
        // Drop the show_items table if it exists from previous changes
        Schema::dropIfExists('show_items');
    }

    public function down()
    {
        Schema::dropIfExists('contact_methods');
    }
}