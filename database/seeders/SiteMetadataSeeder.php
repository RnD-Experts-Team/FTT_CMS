<?php

namespace Database\Seeders;

use App\Models\SiteMetadata;
use App\Models\Media;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class SiteMetadataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // التأكد من أن المجلد موجود، وإذا لم يكن موجودًا، نقوم بإنشائه
        $directory = storage_path('app/public/site_metadata');
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        // إضافة صورة لـ Logo إلى جدول media
        $logo = Media::create([
            'path' => 'site_metadata/logo.jpg', // يجب تغيير المسار إلى المسار الفعلي للصورة
            'type' => 'image',
            'mime_type' => 'image/jpeg',
            'width' => 200,
            'height' => 200,
            'size_bytes' => 10240,
            'alt_text' => 'Logo of the site',
            'title' => 'Site Logo'
        ]);

        // إضافة صورة لـ Favicon إلى جدول media
        $favicon = Media::create([
            'path' => 'site_metadata/favicon.ico', // يجب تغيير المسار إلى المسار الفعلي للصورة
            'type' => 'image',
            'mime_type' => 'image/x-icon',
            'width' => 32,
            'height' => 32,
            'size_bytes' => 2048,
            'alt_text' => 'Favicon of the site',
            'title' => 'Site Favicon'
        ]);

        // إنشاء سجل جديد في جدول site_metadata
        SiteMetadata::create([
            'name' => 'My Awesome Site',
            'description' => 'This is the description of my awesome site.',
            'keywords' => 'awesome, site, metadata, example',
            'logo_media_id' => $logo->id,
            'favicon_media_id' => $favicon->id
        ]);
    }
}