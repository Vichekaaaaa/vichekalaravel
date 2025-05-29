<?php

// app/Models/ContactMethod.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMethod extends Model
{
    protected $fillable = ['title', 'icon', 'url', 'phone_number', 'type'];
}