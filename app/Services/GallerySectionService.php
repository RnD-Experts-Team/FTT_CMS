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

    // دالة لعرض جميع الأقسام
    public function index()
    {
        return GallerySection::all();
    }
}