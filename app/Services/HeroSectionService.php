<?php

namespace App\Services;

use App\Models\HeroSection;
use App\Models\Media;
use App\Models\HeroMedia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
  use getID3;  

class HeroSectionService
{
    public function index()
    {
        try {
             $heroSections = HeroSection::with(['media' => function ($query) {
                $query->orderBy('sort_order', 'asc');  
            }, 'media.media'])  
            ->orderBy('id', 'desc')  
            ->get();

             $response = $heroSections->map(function ($heroSection) {
                return [
                    'subheader' => $heroSection->subheader,
                    'title' => $heroSection->title,
                    'description_html' => $heroSection->description_html,
                    'media' => $heroSection->media->map(function ($mediaItem) {
                        return [
                            'id' => $mediaItem->id,
                            'url' => $mediaItem->media->url,  
                        ];
                    }),
                    'button1_text' => $heroSection->button1_text,
                    'button1_link' => $heroSection->button1_link,
                    'button2_text' => $heroSection->button2_text,
                    'button2_link' => $heroSection->button2_link,
                ];
            });

             return response()->json([
                'success' => true,
                'message' => 'Hero section updated successfully',
                'data' => $response,
                'meta' => []
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch hero section',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function update(HeroSection $section, array $data)
    {
        return DB::transaction(function () use ($section, $data) {

            // 1️⃣ تحديث بيانات النص فقط
            $section->update(
                collect($data)->except('media_files', 'alt_text', 'title_text')->toArray()
            );

            // 2️⃣ حذف بيانات الـ HeroMedia القديمة أولاً
            $section->media()->delete(); // حذف جميع السجلات المرتبطة في جدول hero_media

            // 3️⃣ إذا كان هناك media جديدة → أضفها فقط (بدون حذف القديم)
            if (isset($data['media_files']) && is_array($data['media_files']) && count($data['media_files']) > 0) {

                // تأكد من وجود المجلد
                if (!Storage::disk('public')->exists('uploads/hero')) {
                    Storage::disk('public')->makeDirectory('uploads/hero');
                }

                // آخر sort_order موجود
                $lastSort = $section->media()->max('sort_order') ?? 0;

                // تحقق من أن الـ media_files و alt_text و title_text بنفس العدد
                $mediaCount = count($data['media_files']);
                if ($mediaCount !== count($data['alt_text']) || $mediaCount !== count($data['title_text'])) {
                    throw new \Exception('The number of media files, alt text, and titles must match.');
                }

                foreach ($data['media_files'] as $index => $file) {

                    if (!$file) {
                        continue;
                    }

                    $mime = $file->getMimeType() ?? 'application/octet-stream';
                    $tempPath = $file->getRealPath();

                    // ✅ استخراج width/height
                    $width = 0;
                    $height = 0;

                    if (str_contains($mime, 'image')) {
                        [$width, $height] = $this->getImageDimensions($tempPath);
                    } elseif (str_contains($mime, 'video')) {
                        [$width, $height] = $this->getVideoDimensionsWithGetID3($tempPath);
                    }

                    // تخزين الملف
                    $path = $file->store('uploads/hero', 'public');

                    // إنشاء media record
                    $media = Media::create([
                        'path' => $path,
                        'type' => str_contains($mime, 'video') ? 'video' : (str_contains($mime, 'image') ? 'image' : 'file'),
                        'mime_type' => $mime,
                        'width' => (int)$width,
                        'height' => (int)$height,
                        'size_bytes' => (int)($file->getSize() ?? 0),
                        'alt_text' => $data['alt_text'][$index] ?? 'Hero Media', // استخدام alt_text المناسب
                        'title' => $data['title_text'][$index] ?? ($section->title ?? 'Hero') . ' Media', // استخدام title_text المناسب
                    ]);

                    // ربطها في hero_media مع sort_order جديد
                    HeroMedia::create([
                        'hero_section_id' => $section->id,
                        'media_id' => $media->id,
                        'sort_order' => $lastSort + $index + 1, // حساب sort_order بشكل متسلسل
                    ]);
                }
            }

            // تنسيق البيانات وإرجاع الاستجابة المطلوبة بعد التحديث
            $updatedSection = $this->getHeroSectionData($section);  // استدعاء التابع المشترك

            return response()->json([
                'success' => true,
                'message' => 'Hero section updated successfully',
                'data' => $updatedSection,
                'meta' => []
            ]);
        });
    }

    private function getHeroSectionData(HeroSection $section)
    {
         $section->load(['media' => function ($query) {
            $query->orderBy('sort_order', 'asc');  
        }, 'media.media']);  

         return [
            'subheader' => $section->subheader,
            'title' => $section->title,
            'description_html' => $section->description_html,
            'media' => $section->media->map(function ($mediaItem) {
                return [
                    'id' => $mediaItem->id,
                    'url' => $mediaItem->media->url,  
                ];
            }),
            'button1_text' => $section->button1_text,
            'button1_link' => $section->button1_link,
            'button2_text' => $section->button2_text,
            'button2_link' => $section->button2_link,
        ];
    }

 
    private function getImageDimensions(string $path): array
    {
        $info = @getimagesize($path);
        if (!$info) {
            return [0, 0];
        }
        return [(int)$info[0], (int)$info[1]];
    }

    private function getVideoDimensionsWithGetID3(string $path): array
    {
        // إنشاء كائن getID3
        $getID3 = new getID3();

        // تحليل الفيديو باستخدام getID3
        $fileInfo = $getID3->analyze($path);

        // التأكد من وجود معلومات الفيديو
        if (isset($fileInfo['video'])) {
            $width = $fileInfo['video']['resolution_x'] ?? 0;  // عرض الفيديو
            $height = $fileInfo['video']['resolution_y'] ?? 0; // ارتفاع الفيديو
        } else {
            $width = 0;
            $height = 0;
        }

        return [$width, $height];
    }

 
 
}