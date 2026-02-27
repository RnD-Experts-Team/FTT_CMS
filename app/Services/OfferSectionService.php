<?php

namespace App\Services;

use App\Models\OfferSection;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Throwable;

class OfferSectionService
{
    public function update(int $id, array $data, $newIcon): OfferSection
    {
        try {
            // العثور على السجل المطلوب تحديثه
            $section = OfferSection::find($id);
            if (!$section) {
                throw new \Exception('Offer section not found.');
            }

            // التعامل مع الصورة في حال كانت موجودة
            if ($newIcon) {
                // تأكد من أن المجلد موجود، إذا لم يكن موجودًا، قم بإنشائه
                $directory = storage_path('app/public/offersections');
                if (!is_dir($directory)) {
                    mkdir($directory, 0777, true);  // إنشاء المجلد مع الأذونات
                }

                // إذا كان هناك صورة قديمة، احذفها
                if ($section->image) {
                    Storage::disk('public')->delete($section->image->path);
                    $section->image->delete();
                }

                // حفظ الصورة الجديدة في مجلد offersections
                $path = $newIcon->store('offersections', 'public'); // حفظ الصورة في المجلد المناسب
                $media = Media::create([
                    'path' => $path,
                    'type' => 'image',
                    'mime_type' => $newIcon->getClientMimeType(),
                    'width' => getimagesize($newIcon)[0], // عرض الصورة
                    'height' => getimagesize($newIcon)[1], // ارتفاع الصورة
                    'size_bytes' => $newIcon->getSize(),
                    'alt_text' => $data['alt_text'] ?? '',
                    'title' => $data['image_title'] ?? '',
                ]);
                $data['image_media_id'] = $media->id; // ربط الصورة الجديدة بالسجل
            }

            // تحديث السجل بالبيانات الجديدة
            $section->update($data);
            return $section;
        } catch (Throwable $e) {
            throw new \Exception('Error updating offer section: ' . $e->getMessage());
        }
    }

   public function index()
    {
        return OfferSection::with(['image', 'requirements'])->get();
    }
}