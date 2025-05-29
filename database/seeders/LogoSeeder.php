<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Logo;

class LogoSeeder extends Seeder
{
    public function run(): void
    {
        Logo::create([
            'url' => 'http://127.0.0.1:8000/images/logo.png'
        ]);
    }
}