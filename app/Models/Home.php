<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    protected $table = 'home';

    protected $fillable = [
        'name',
        'roles',
        'stats',
        'social_links',
        'bio',
        'cta_text',
        'cta_bio', // Add cta_bio to fillable
        'buttons',
        'cta_buttons',
    ];

    protected $casts = [
        'roles' => 'array',
        'stats' => 'array',
        'social_links' => 'array',
        'buttons' => 'array',
        'cta_buttons' => 'array',
    ];

    public $timestamps = true;
}