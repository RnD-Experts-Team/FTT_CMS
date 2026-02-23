<?php

namespace App\Services;

use App\Models\FounderSection;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;

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

            // 3) استخراج أبعاد الفيديو من الملف المؤقت قبل التخزين
            [$width, $height] = $this->getVideoDimensionsWithFfprobe($file->getRealPath());

            // 4) تخزين الفيديو
            $path = $file->store('uploads/videos', 'public');

            // 5) إنشاء سجل Media
            $media = Media::create([
                'path' => $path,
                'type' => 'video',
                'mime_type' => $file->getMimeType(),
                'width' => $width ?? 0,
                'height' => $height ?? 0,
                'size_bytes' => $file->getSize(),
                'alt_text' => 'Founder Video',
                'title' => 'Founder Uploaded Video',
            ]);

            $section->video_media_id = $media->id;
        }

        $section->update(collect($data)->except('video')->toArray());

        return $section->load('video');
    }

    private function getVideoDimensionsWithFfprobe(string $filePath): array
    {
        // ffprobe -v error -select_streams v:0 -show_entries stream=width,height -of json input.mp4
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
            // إذا ffprobe غير موجود أو فشل، رجّع nulls
            return [null, null];
        }

        $json = json_decode($process->getOutput(), true);

        $stream = $json['streams'][0] ?? null;
        $width  = $stream['width'] ?? null;
        $height = $stream['height'] ?? null;

        return [$width, $height];
    }
}