<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tutorial;
use Illuminate\Database\Seeder;

class TutorialSeeder extends Seeder
{
    public function run()
    {
        $webHosting = Category::create(['name' => 'Web Hosting Tutorials', 'slug' => 'web-hosting']);
        $roadmap = Category::create(['name' => 'Roadmap Tutorials', 'slug' => 'roadmap']);

        Tutorial::create([
            'title' => 'Web Hosting Basics',
            'description' => 'Learn the basics of web hosting.',
            'link' => 'https://example.com/web-hosting',
            'image' => 'tutorials/web-hosting.jpg',
            'category_id' => $webHosting->id,
        ]);

        Tutorial::create([
            'title' => 'Developer Roadmap 2025',
            'description' => 'A complete roadmap for developers.',
            'link' => 'https://example.com/roadmap',
            'image' => 'tutorials/roadmap.jpg',
            'category_id' => $roadmap->id,
        ]);
    }
}