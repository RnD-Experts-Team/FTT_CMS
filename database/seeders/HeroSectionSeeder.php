<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HeroSection;

class HeroSectionSeeder extends Seeder
{
    public function run(): void
    {
        HeroSection::updateOrCreate(
            ['id' => 1],
            [
                'subheader' => 'Welcome to Our Platform',
                'title' => 'Build Your Future With Us',
                'description_html' => '<p>We help you grow your business with innovative solutions.</p>',
                'button1_text' => 'Get Started',
                'button1_link' => '/get-started',
                'button2_text' => 'Learn More',
                'button2_link' => '/about-us',
            ]
        );
    }
}