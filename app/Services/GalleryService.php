<?php

namespace App\Services;

use App\Models\GallerySection;

class GalleryService
{
    /**
     * استرجاع بيانات الـ GallerySection مع الـ GalleryItem وترتيبهم حسب sort_order.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getGallerySections()
    {
        // تحميل بيانات GallerySection مع GalleryItem المرتبطة بها
        $gallerySections = GallerySection::with(['items' => function ($query) {
            // تحميل media مع ترتيب الـ items حسب sort_order
            $query->with('image')->orderBy('sort_order', 'asc');
        }])->get();

        // تنسيق الاستجابة
        return $gallerySections->map(function ($section) {
            return [
                'hook' => $section->hook,
                'title' => $section->title,
                'description' => $section->description,
                'images' => $section->items->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'image_url' => $item->image->url,  // إرجاع الـ URL للصور
                        'title' => $item->title,
                        'description' => $item->description
                    ];
                })
            ];
        });
    }
}