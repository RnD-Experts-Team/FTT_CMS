<?php

namespace App\Services;

use App\Models\Media;
use App\Models\TemptationSection;
use Illuminate\Support\Facades\Storage;

class TemptationSectionService
{
    public function index()
    {
         return TemptationSection::with(['image', 'requirements'])->get();
    }

    public function update(TemptationSection $section, array $data): TemptationSection
    {
         if (isset($data['image'])) {
            
             if (isset($section->image_media_id)) {
                $oldImage = Media::find($section->image_media_id);
                if ($oldImage) {
                    $this->deleteOldImage($oldImage);  
                }
            }
             $image = $this->storeImage($data['image'], $data['title'] ?? '', $data['alt_text'] ?? '');
             $data['image_media_id'] = $image->id;
        }


         $section->update($data);
         $section->refresh()->load('image');

         return $section->load('image');
    }

    public function storeImage($file, string $title, string $altText): Media
    {
         $this->createDirectoryIfNotExists('uploads/temptation');

         $path = $file->store('uploads/temptation', 'public');

         [$width, $height] = $this->getImageDimensions($file->getRealPath());

         return Media::create([
            'path' => $path,
            'type' => 'image',
            'mime_type' => $file->getMimeType(),
            'width' => $width,
            'height' => $height,
            'size_bytes' => $file->getSize(),
            'alt_text' => $altText,
            'title' => $title,
        ]);
    }

    private function getImageDimensions(string $path): array
    {
        // استخراج الأبعاد (عرض وارتفاع الصورة)
        $info = @getimagesize($path);
        if (!$info) {
            return [0, 0];
        }
        return [(int)$info[0], (int)$info[1]];
    }

    private function deleteOldImage(Media $oldImage): void
    {
        // تحقق مما إذا كانت الصورة موجودة في المجلد، وإذا كانت موجودة، احذفها
        if (Storage::disk('public')->exists($oldImage->path)) {
            Storage::disk('public')->delete($oldImage->path);
        }

        // حذف السجل من جدول media
        $oldImage->delete();
    }

    private function createDirectoryIfNotExists(string $directory): void
    {
        // التحقق من وجود المجلد، وإذا لم يكن موجودًا نقوم بإنشائه
        if (!Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->makeDirectory($directory);
        }
    }
}