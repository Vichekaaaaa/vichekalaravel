<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupportUsSeeder extends Seeder
{
    public function run(): void
    {
        $supportData = [
            [
                'section' => 'intro',
                'title' => 'Support My Work',
                'description' => 'Hi, I’m NY Vicheka! I’m passionate about creating web applications, sharing tutorials, and building tools that make a difference. Maintaining this platform, creating content, and developing new projects takes time and resources. If you’ve found my work helpful, I’d greatly appreciate your support! Your support helps me keep this site running, create more free tutorials, and dedicate time to open-source projects. Here are a few ways you can support me:',
                'buttons' => null,
                'order' => 1,
            ],
            [
                'section' => 'donate',
                'title' => 'Donate',
                'description' => 'A small donation can go a long way! Support me via PayPal or Buy Me a Coffee.',
                'buttons' => json_encode([
                    ['text' => 'PayPal', 'url' => 'https://paypal.me/yourpaypal'],
                    ['text' => 'Buy Me a Coffee', 'url' => 'https://buymeacoffee.com/yourprofile'],
                ]),
                'order' => 2,
            ],
            [
                'section' => 'sponsor',
                'title' => 'Sponsor a Project',
                'description' => 'Interested in sponsoring a specific project or tutorial series? Let’s collaborate!',
                'buttons' => json_encode([
                    ['text' => 'Contact Me', 'url' => '/contact'],
                ]),
                'order' => 3,
            ],
            [
                'section' => 'share',
                'title' => 'Share My Work',
                'description' => 'Help spread the word by sharing my tutorials and projects with your network.',
                'buttons' => json_encode([
                    ['text' => 'Twitter', 'url' => 'https://twitter.com/intent/tweet?text=Check%20out%20NY%20Vicheka\'s%20amazing%20web%20dev%20tutorials!&url=https://yourwebsite.com'],
                    ['text' => 'LinkedIn', 'url' => 'https://www.linkedin.com/sharing/share-offsite/?url=https://yourwebsite.com'],
                ]),
                'order' => 4,
            ],
            [
                'section' => 'thank_you',
                'title' => 'Thank You for Your Support!',
                'description' => 'Every bit of support means the world to me. It keeps me motivated to create more content and build better tools for the community.',
                'buttons' => null,
                'order' => 5,
            ],
        ];

        DB::table('support_us')->insert($supportData);
    }
}