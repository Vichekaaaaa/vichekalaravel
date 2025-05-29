<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;

    protected $fillable = [
        'bio',
        'skills',
        'experience',
        'education',
        'hobbies',
        'image',
    ];

    protected $casts = [
        'skills' => 'array',
        'experience' => 'array',
        'education' => 'array',
    ];

    protected $attributes = [
        'skills' => '[]',
        'experience' => '[]',
        'education' => '[]',
    ];
}