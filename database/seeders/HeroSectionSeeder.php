<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HeroSection;
use App\Models\Media;
use App\Models\HeroMedia;

class HeroSectionSeeder extends Seeder
{
    public function run(): void
    {
        // 1️⃣ إنشاء Hero Section
        $hero = HeroSection::updateOrCreate(
            ['id' => 1],
            [
                'subheader' => 'Welcome to Our Platform',
                'title' => 'Build Your Future With Us',
                'description_html' => '<p>This is the hero section description in HTML format.</p>',
                'button1_text' => 'Get Started',
                'button1_link' => 'https://example.com/start',
                'button2_text' => 'Learn More',
                'button2_link' => 'https://example.com/about',
            ]
        );

        // 2️⃣ إنشاء Media افتراضية

        $mediaItems = [
            [
                'path' => 'uploads/hero/default-image-1.jpg',
                'type' => 'image',
                'mime_type' => 'image/jpeg',
                'width' => 1920,
                'height' => 1080,
                'size_bytes' => 150000,
                'alt_text' => 'Hero Image 1',
                'title' => 'Hero Image 1',
            ],
            [
                'path' => 'uploads/hero/default-image-2.jpg',
                'type' => 'image',
                'mime_type' => 'image/jpeg',
                'width' => 1920,
                'height' => 1080,
                'size_bytes' => 180000,
                'alt_text' => 'Hero Image 2',
                'title' => 'Hero Image 2',
            ],
            [
                'path' => 'uploads/hero/default-video.mp4',
                'type' => 'video',
                'mime_type' => 'video/mp4',
                'width' => 1920,
                'height' => 1080,
                'size_bytes' => 5000000,
                'alt_text' => 'Hero Video',
                'title' => 'Hero Video',
            ],
        ];

        foreach ($mediaItems as $index => $mediaData) {

            $media = Media::updateOrCreate(
                ['path' => $mediaData['path']],
                $mediaData
            );

            HeroMedia::updateOrCreate(
                [
                    'hero_section_id' => $hero->id,
                    'media_id' => $media->id
                ],
                [
                    'sort_order' => $index + 1
                ]
            );
        }
    }
}