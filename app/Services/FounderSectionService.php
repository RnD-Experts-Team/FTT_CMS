<?php

namespace App\Services;

use App\Models\FounderSection;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
  use getID3;

class FounderSectionService
{
    public function index()
    {
        return FounderSection::with('video')->get();
    }


    public function update(FounderSection $section, array $data)
    {
        
        if (isset($data['video'])) {
            $file = $data['video'];

            // 1) تأكد أن المجلد موجود
            if (!Storage::disk('public')->exists('uploads/videos')) {
                Storage::disk('public')->makeDirectory('uploads/videos');
            }

            // 2) حذف الفيديو القديم + سجل الميديا القديم
            if ($section->video) {
                if (Storage::disk('public')->exists($section->video->path)) {
                    Storage::disk('public')->delete($section->video->path);
                }
                $section->video->delete();
            }

            // 3) استخراج أبعاد الفيديو من الملف المؤقت باستخدام getID3
            [$width, $height] = $this->getVideoDimensionsWithGetID3($file->getRealPath());

            // 4) تخزين الفيديو
            $path = $file->store('uploads/videos', 'public');

            // 5) إنشاء سجل Media للفيديو
            $media = Media::create([
                'path' => $path,
                'type' => 'video',
                'mime_type' => $file->getMimeType(),
                'width' => $width ?? 0,
                'height' => $height ?? 0,
                'size_bytes' => $file->getSize(),
                'alt_text' => $data['alt_text'] ?? '',
                'title' => $data['title_video'] ?? 'Founder Uploaded Video',
              ]);

            $section->video_media_id = $media->id;
        }

        // تحديث البيانات الأخرى في السجل
        $section->update(collect($data)->except('video')->toArray());

        return $section->load('video');
    }

    private function getVideoDimensionsWithGetID3(string $filePath): array
    {
        // إنشاء كائن getID3
        $getID3 = new getID3();

        // تحليل الفيديو باستخدام getID3
        $fileInfo = $getID3->analyze($filePath);

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