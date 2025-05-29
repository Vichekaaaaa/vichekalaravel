<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportUs extends Model
{
    use HasFactory;

    protected $table = 'support_us';

    protected $fillable = [
        'section',
        'parent_section',
        'title',
        'description',
        'buttons',
        'icon',
        'order',
        'style', // Add style to fillable
    ];

    protected $casts = [
        'buttons' => 'array',
    ];
}