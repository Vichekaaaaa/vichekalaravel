<?php

namespace Database\Seeders;

use App\Models\About;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        About::create([
            'bio' => "Hello! I’m NY Vicheka, a dedicated web developer with a passion for creating seamless, user-friendly, and visually appealing digital experiences. My expertise lies in React for building dynamic, responsive front-end applications and Laravel for crafting robust, scalable back-end systems.",
            'skills' => [
                'React', 'JavaScript (ES6+)', 'HTML5', 'CSS3', 'Tailwind CSS', 'Responsive Design',
                'Laravel', 'PHP', 'MySQL', 'RESTful APIs', 'Node.js',
                'Git', 'Vite', 'Webpack', 'Figma', 'Agile Methodologies', 'CI/CD'
            ],
            'experience' => [
                [
                    'title' => 'Full-Stack Developer',
                    'company' => 'TechSolutions Inc.',
                    'period' => 'June 2022 - Present',
                    'description' => [
                        'Developed and maintained web applications using React and Laravel, improving user engagement by 30%.',
                        'Designed RESTful APIs to enable seamless communication between front-end and back-end systems.',
                        'Collaborated with cross-functional teams to deliver projects on time using Agile methodologies.'
                    ]
                ],
                [
                    'title' => 'Freelance Web Developer',
                    'company' => 'Self-Employed',
                    'period' => 'Jan 2020 - May 2022',
                    'description' => [
                        'Built custom websites for small businesses, focusing on responsive design and performance optimization.',
                        'Integrated third-party APIs for payment gateways and social media functionalities.'
                    ]
                ]
            ],
            'education' => [
                [
                    'degree' => 'Bachelor of Science in Computer Science',
                    'institution' => 'Royal University of Phnom Penh',
                    'period' => '2016 - 2020',
                    'description' => 'Graduated with honors, specializing in software engineering. My final project was a web-based task management system built with Laravel and JavaScript.'
                ]
            ],
            'hobbies' => 'When I’m not coding, I love exploring new technologies, experimenting with UI/UX design in Figma, and keeping up with the latest trends in web development. I also enjoy photography, capturing moments during my travels, and unwinding with a good book or a cup of coffee at a cozy café.',
            'image' => null, // Set to a valid path if you have an image
        ]);
    }
}