<?php

namespace App\Services;

use App\Models\Media;
use App\Models\TemptationSection;
use Illuminate\Support\Facades\Storage;

class TemptationSectionService
{
    public function index()
    {
        // جلب بيانات TemptationSection مع تحميل الصورة المرتبطة بها
        return TemptationSection::with('image')->get();
    }
    public function update(TemptationSection $section, array $data): TemptationSection
    {
        // إذا كانت هناك صورة جديدة يتم حذف الصورة القديمة أولاً
        if (isset($data['image_media_id'])) {
            $oldImage = Media::find($section->image_media_id);
            if ($oldImage) {
                // حذف الصورة القديمة
                $this->deleteOldImage($oldImage);
            }
        }

        // تحديث السجل (البيانات النصية مثل hook, title, description, إلخ)
        $section->update($data);

        // تحميل السجل بعد التحديث
        return $section->load('image');
    }

    public function storeImage($file, string $title, string $altText): Media
    {
        // التأكد من أن المجلد موجود، وإذا لم يكن موجودًا نقوم بإنشائه
        $this->createDirectoryIfNotExists('uploads/temptation');

        // تخزين الصورة
        $path = $file->store('uploads/temptation', 'public');

        // استخراج الأبعاد (عرض وارتفاع الصورة)
        [$width, $height] = $this->getImageDimensions($file->getRealPath());

        // إنشاء سجل في جدول الـ media
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