<?php

namespace App\Services;

use App\Models\HeroSection;
use App\Models\Media;
use App\Models\HeroMedia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;

class HeroSectionService
{
    public function index()
    {
        return HeroSection::with('media.media')
            ->orderBy('id','desc')
            ->get();
    }

    public function update(HeroSection $section, array $data)
    {
        return DB::transaction(function () use ($section, $data) {

            // 1️⃣ تحديث بيانات النص فقط
            $section->update(
                collect($data)->except('media_files')->toArray()
            );

            // 2️⃣ إذا في media جديدة → أضفهم فقط (بدون حذف القديم)
            if (isset($data['media_files']) && is_array($data['media_files']) && count($data['media_files']) > 0) {

                // تأكد من وجود المجلد
                if (!Storage::disk('public')->exists('uploads/hero')) {
                    Storage::disk('public')->makeDirectory('uploads/hero');
                }

                // آخر sort_order موجود
                $lastSort = $section->media()->max('sort_order') ?? 0;

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
                        [$width, $height] = $this->getVideoDimensions($tempPath);
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
                        'alt_text' => 'Hero Media',
                        'title' => ($section->title ?? 'Hero') . ' Media',
                    ]);

                    // ربطها في hero_media مع sort_order جديد
                    HeroMedia::create([
                        'hero_section_id' => $section->id,
                        'media_id' => $media->id,
                        'sort_order' => $lastSort + $index + 1,
                    ]);
                }
            }

            return $section->load('media.media');
        });
    }

    private function getImageDimensions(string $path): array
    {
        $info = @getimagesize($path);
        if (!$info) {
            return [0, 0];
        }
        return [(int)$info[0], (int)$info[1]];
    }

    private function getVideoDimensions(string $path): array
    {
        $process = new Process([
            'ffprobe',
            '-v', 'error',
            '-select_streams', 'v:0',
            '-show_entries', 'stream=width,height',
            '-of', 'json',
            $path
        ]);

        $process->run();

        if (!$process->isSuccessful()) {
            return [0, 0];
        }

        $json = json_decode($process->getOutput(), true);
        $stream = $json['streams'][0] ?? null;

        return [
            (int)($stream['width'] ?? 0),
            (int)($stream['height'] ?? 0),
        ];
    }
}