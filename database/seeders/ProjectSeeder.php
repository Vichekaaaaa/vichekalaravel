<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        Project::create([
            'title' => 'Sample Project 1',
            'description' => 'A sample project description.',
            'image' => 'projects/sample1.jpg', // Relative to storage/app/public
            'link' => 'https://example.com/project1',
        ]);
        Project::create([
            'title' => 'Sample Project 2', // Fixed: Added '=>'
            'description' => 'Another sample project.',
            'image' => 'projects/sample2.jpg',
            'link' => 'https://example.com/project2',
        ]);
    }
}