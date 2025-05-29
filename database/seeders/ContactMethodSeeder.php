<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContactMethod;

class ContactMethodSeeder extends Seeder
{
    public function run()
    {
        ContactMethod::create([
            'title' => 'Call Us',
            'icon' => 'fa-phone',
            'url' => 'tel:+1234567890',
            'type' => 'phone',
        ]);

        ContactMethod::create([
            'title' => 'Email Us',
            'icon' => 'fa-envelope',
            'url' => 'mailto:contact@yourdomain.com',
            'type' => 'email',
        ]);

        ContactMethod::create([
            'title' => 'Twitter',
            'icon' => 'fa-twitter',
            'url' => 'https://twitter.com/yourhandle',
            'type' => 'social',
        ]);

        ContactMethod::create([
            'title' => 'Facebook',
            'icon' => 'fa-facebook',
            'url' => 'https://facebook.com/yourpage',
            'type' => 'social',
        ]);
    }
}