<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OfferSection;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;

class OfferSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // إضافة سجل جديد إلى جدول media
        $media = Media::create([
            'path' => 'icons/sample-offer-image.jpg', // مسار الصورة
            'type' => 'image',
            'mime_type' => 'image/jpeg',
            'width' => 800, // أبعاد الصورة
            'height' => 600,
            'size_bytes' => 102400, // حجم الصورة بالبايت
            'alt_text' => 'Sample Offer Image', // النص البديل
            'title' => 'Sample Offer Image Title' // العنوان
        ]);

        // إضافة سجل جديد إلى جدول offer_sections
        OfferSection::create([
            'hook' => 'Limited Time Offer',  // النص الذي يظهر في البداية
            'title' => 'Special Discount', // العنوان
            'description' => 'Get an exclusive discount for a limited time. Act fast and claim your offer now!', // الوصف
            'button_text' => 'Claim Now', // نص الزر
            'button_link' => 'http://example.com/offer', // الرابط
            'image_media_id' => $media->id // ربط الصورة من جدول media
        ]);
    }
}