<?php

namespace App\Services;

use App\Models\GallerySection;
use Throwable;

class GallerySectionService
{
    // دالة للتحديث
    public function update(int $id, array $data): GallerySection
    {
        try {
            $gallerySection = GallerySection::find($id);
            if (!$gallerySection) {
                throw new \Exception('Gallery section not found.');
            }

            // تحديث السجل
            $gallerySection->update($data);
            return $gallerySection;
        } catch (Throwable $e) {
            throw new \Exception('Error updating gallery section: ' . $e->getMessage());
        }
    }

    public function index()
    {
        // استرجاع جميع الـ GallerySection مع الـ media المرتبطة بها
        $gallerySections = GallerySection::with(['items' => function ($query) {
                $query->orderBy('sort_order', 'asc'); // ترتيب العناصر حسب sort_order
                $query->with('image'); // تحميل الـ media المرتبطة بكل GalleryItem
            }])
            ->orderBy('id', 'desc') // ترتيب الـ GallerySection حسب ID تنازليًا
            ->get();

        // بناء الرد كما في المثال المطلوب
        $data = $gallerySections->map(function ($section) {
            return [
                'gallery_section' => [
                    'hook' => $section->hook,
                    'title' => $section->title,
                    'description' => $section->description,
                    'images' => $section->items->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'image_url' => $item->image->path,  // الحصول على مسار الصورة من media
                            'title' => $item->image->title,    // عنوان الصورة
                            'description' => $item->description
                        ];
                    })
                ]
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Gallery section retrieved successfully',
            'data' => $data
        ]);
    }
}