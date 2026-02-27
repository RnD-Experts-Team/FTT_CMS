<?php

namespace Database\Seeders;

use App\Models\TemptationSection;
use App\Models\Media;
use Illuminate\Database\Seeder;

class TemptationSectionSeeder extends Seeder
{
     
    public function run()
    {
        // إنشاء سجل واحد لجدول media
        $media = Media::create([
            'path' => 'images/sample.jpg',
            'type' => 'image',
            'mime_type' => 'image/jpeg',
            'width' => 800,
            'height' => 600,
            'size_bytes' => 204800,
            'alt_text' => 'Sample Image',
            'title' => 'Sample Image Title',
        ]);

        // إنشاء سجل واحد لجدول temptation_sections مع ربطه بالـ media
        TemptationSection::create([
            'hook' => 'Special Offer',
            'title' => 'Exclusive Deal for You',
            'description' => 'This is a special temptation section where you can get amazing discounts.',
            'button1_text' => 'Buy Now',
            'button1_link' => 'https://example.com/buy',
            'button2_text' => 'Learn More',
            'button2_link' => 'https://example.com/learn',
            'image_media_id' => $media->id,  // ربط الـ media بـ temptation_section
        ]);
    }
}