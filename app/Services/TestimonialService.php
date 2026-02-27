<?php

namespace App\Services;

use App\Models\Testimonial;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;
 use getID3;
use Symfony\Component\Process\Process;

class TestimonialService
{
     // تابع لجلب جميع Testimonials وترتيبها حسب sort_order
    public function getAll()
    {
    return Testimonial::with('video')->orderBy('sort_order', 'asc')->get();
    }

    // تابع لجلب Testimonial واحد بناءً على الـ ID
    public function getById(int $id)
    {
        return Testimonial::findOrFail($id);
    }


    public function create(array $data)
    {
        // Check if the sort_order is already in use
        $existingItem = Testimonial::where('sort_order', $data['sort_order'])->first();
        
        // If the sort_order already exists, increment it until it's unique
        if ($existingItem) {
            do {
                $data['sort_order'] += 1;
                $existingItem = Testimonial::where('sort_order', $data['sort_order'])->first();
            } while ($existingItem);
        }

        // إذا كان هناك فيديو جديد، نقوم بحفظه
        if (isset($data['video'])) {
            $file = $data['video'];

            // 1) تأكد أن المجلد موجود
            if (!Storage::disk('public')->exists('uploads/videos')) {
                Storage::disk('public')->makeDirectory('uploads/videos');
            }

            // 2) استخراج أبعاد الفيديو من الملف المؤقت قبل التخزين
            [$width, $height] = $this->getVideoDimensionsWithGetID3($file->getRealPath());

            // 3) تخزين الفيديو
            $path = $file->store('uploads/videos', 'public');

            // 4) إنشاء سجل Media للفيديو
            $media = Media::create([
                'path' => $path,
                'type' => 'video',
                'mime_type' => $file->getMimeType(),
                'width' => $width ?? 0,
                'height' => $height ?? 0,
                'size_bytes' => $file->getSize(),
                'alt_text' => $data['alt_text'] ?? '',
                'title' => $data['title'] ?? 'Testimonial Video',
            ]);

            // إضافة video_media_id إلى البيانات
            $data['video_media_id'] = $media->id;
        }

        // إنشاء Testimonial باستخدام البيانات المدخلة
        return Testimonial::create($data);
    }

    public function update(int $id, array $data)
    {
        $testimonial = Testimonial::findOrFail($id);

        // Check if the sort_order is already in use
        $existingItem = Testimonial::where('sort_order', $data['sort_order'])->first();
        
        // If the sort_order already exists, increment it until it's unique
        if ($existingItem) {
            do {
                $data['sort_order'] += 1;
                $existingItem = Testimonial::where('sort_order', $data['sort_order'])->first();
            } while ($existingItem);
        }

        // إذا كان هناك فيديو جديد، نقوم بحذفه من جدول Media
        if (isset($data['video'])) {
            if ($testimonial->video) {
                // 1) حذف الفيديو القديم
                if (Storage::disk('public')->exists($testimonial->video->path)) {
                    Storage::disk('public')->delete($testimonial->video->path);
                }
                // 2) حذف السجل القديم من جدول Media
                $testimonial->video->delete();
            }

            // 3) تخزين الفيديو الجديد
            $file = $data['video'];

            // 4) تأكد أن المجلد موجود
            if (!Storage::disk('public')->exists('uploads/videos')) {
                Storage::disk('public')->makeDirectory('uploads/videos');
            }

            // 5) استخراج أبعاد الفيديو من الملف المؤقت
            [$width, $height] = $this->getVideoDimensionsWithGetID3($file->getRealPath());

            // 6) تخزين الفيديو الجديد
            $path = $file->store('uploads/videos', 'public');

            // 7) إنشاء سجل Media للفيديو الجديد
            $media = Media::create([
                'path' => $path,
                'type' => 'video',
                'mime_type' => $file->getMimeType(),
                'width' => $width ?? 0,
                'height' => $height ?? 0,
                'size_bytes' => $file->getSize(),
                'alt_text' => $data['alt_text'] ?? '',
                'title' => $data['title'] ?? 'Testimonial Video',
            ]);

            // إضافة video_media_id إلى البيانات
            $data['video_media_id'] = $media->id;
        }

        // تحديث بيانات الـ Testimonial (ما عدا الفيديو)
        $testimonial->update(collect($data)->except('video')->toArray());

        return $testimonial;
    }

    public function delete(int $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        // If the testimonial has a video, delete it
        if ($testimonial->video) {
            Storage::disk('public')->delete($testimonial->video->path);
            $testimonial->video->delete();
        }

        // Delete the testimonial
        $testimonial->delete();
    }
 
       // تابع لاستخراج أبعاد الفيديو باستخدام getID3
    private function getVideoDimensionsWithGetID3(string $filePath): array
    {
        // إنشاء كائن getID3
        $getID3 = new getID3;

        // تحليل الفيديو
        $fileInfo = $getID3->analyze($filePath);

        // التحقق إذا كانت البيانات موجودة
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