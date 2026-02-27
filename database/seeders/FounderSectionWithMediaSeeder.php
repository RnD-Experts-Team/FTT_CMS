<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Media;
use App\Models\FounderSection;

class FounderSectionWithMediaSeeder extends Seeder
{
    public function run(): void
    {
        // 1) Create/Update default media (video)
        $media = Media::updateOrCreate(
            ['path' => 'uploads/videos/default-founder-video.mp4'], // unique-ish key
            [
                'type' => 'video',
                'mime_type' => 'video/mp4',
                'width' => 1920,
                'height' => 1080,
                'size_bytes' => 5000000,
                'alt_text' => 'Founder Introduction Video',
                'title' => 'Founder Video (Default)',
            ]
        );

        // 2) Create/Update founder section referencing that media
        FounderSection::updateOrCreate(
            ['id' => 1],
            [
                'hook_text' => 'Meet Our Founder',
                'title' => 'A Visionary Leader',
                'description' => 'Our founder has years of experience building successful companies.',
                'video_media_id' => $media->id,
            ]
        );
    }
}