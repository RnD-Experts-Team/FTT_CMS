<?php

namespace App\Services;

use App\Models\Testimonial;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use FFMpeg\FFProbe;
use Exception;
use Symfony\Component\Process\Process;

class TestimonialService
{
     // تابع لجلب جميع Testimonials وترتيبها حسب sort_order
    public function getAll()
    {
        return Testimonial::orderBy('sort_order', 'asc')->get();
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
            [$width, $height] = $this->getVideoDimensionsWithFfprobe($file->getRealPath());

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
            [$width, $height] = $this->getVideoDimensionsWithFfprobe($file->getRealPath());

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
    private function getVideoDimensionsWithFfprobe(string $filePath): array
    {
        // استخدام ffprobe لاستخراج أبعاد الفيديو
        $process = new Process([
            'ffprobe',
            '-v', 'error',
            '-select_streams', 'v:0',
            '-show_entries', 'stream=width,height',
            '-of', 'json',
            $filePath,
        ]);

        $process->run();

        if (!$process->isSuccessful()) {
            // إذا حدث فشل في عملية ffprobe، نرجع أبعادًا null
            return [null, null];
        }

        // معالجة إخراج ffprobe لاستخراج الأبعاد
        $json = json_decode($process->getOutput(), true);

        $stream = $json['streams'][0] ?? null;
        $width  = $stream['width'] ?? null;
        $height = $stream['height'] ?? null;

        return [$width, $height];
    }
}