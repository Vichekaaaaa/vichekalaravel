<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tutorial extends Model
{
    protected $fillable = ['title', 'description', 'link', 'image', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}