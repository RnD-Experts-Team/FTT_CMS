<?php

namespace App\Services;

use App\Models\GalleryItem;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Throwable;

class GalleryItemService
{
    // دالة لإنشاء GalleryItem جديد
    public function store(array $data, $image): GalleryItem
    {
        try {
            // التحقق من فريدية sort_order
            if (isset($data['sort_order'])) {
                $existingSortOrder = GalleryItem::where('sort_order', $data['sort_order'])->exists();
                while ($existingSortOrder) {
                    $data['sort_order'] += 1;  // إضافة 1 إلى sort_order حتى يصبح فريدًا
                    $existingSortOrder = GalleryItem::where('sort_order', $data['sort_order'])->exists();
                }
            } else {
                $maxSortOrder = GalleryItem::max('sort_order');
                $data['sort_order'] = $maxSortOrder + 1;
            }

            // تحقق من وجود مجلد الصور
            $galleryItemsFolder = storage_path('app/public/gallery_items');
            if (!is_dir($galleryItemsFolder)) {
                mkdir($galleryItemsFolder, 0777, true);
            }

            // حفظ الصورة في المجلد
            $imagePath = $image->store('gallery_items', 'public');
            
            // حفظ الصورة في جدول media
            $media = Media::create([
                'path' => $imagePath,
                'type' => 'image',
                'mime_type' => $image->getClientMimeType(),
                'width' => getimagesize($image)[0],
                'height' => getimagesize($image)[1],
                'size_bytes' => $image->getSize(),
                'alt_text' => $data['alt_text'],
                'title' => $data['image_title'],
            ]);

            // إضافة الـ media_id للصورة في البيانات
            $data['image_media_id'] = $media->id;

            // حفظ العنصر في GalleryItems
            return GalleryItem::create($data);
        } catch (Throwable $e) {
            throw new \Exception('Error creating gallery item: ' . $e->getMessage());
        }
    }

    // دالة لعرض جميع العناصر
    public function index()
    {
        return GalleryItem::with('image')->orderBy('sort_order')->get();
    }

    // دالة لعرض العنصر بناءً على الـ ID
    public function show(int $id): ?GalleryItem
    {
        return GalleryItem::with('image')->find($id);
    }

    // دالة لتحديث GalleryItem
    public function update(int $id, array $data, $image = null): GalleryItem
    {
        try {
            // البحث عن العنصر بناءً على الـ ID
            $galleryItem = GalleryItem::find($id);
            if (!$galleryItem) {
                throw new \Exception('Gallery item not found.');
            }

            // التحقق من فريدية sort_order
            if (isset($data['sort_order'])) {
                $existingSortOrder = GalleryItem::where('sort_order', $data['sort_order'])->exists();
                while ($existingSortOrder) {
                    $data['sort_order'] += 1;  // إضافة 1 إلى sort_order حتى يصبح فريدًا
                    $existingSortOrder = GalleryItem::where('sort_order', $data['sort_order'])->exists();
                }
            }

            // إذا كانت هناك صورة جديدة، نقوم بحذف الصورة القديمة وإضافة الجديدة
            if ($image) {
                // حذف الصورة القديمة إذا كانت موجودة
                if ($galleryItem->image) {
                    Storage::disk('public')->delete($galleryItem->image->path);
                    $galleryItem->image->delete();
                }

                // حفظ الصورة الجديدة في المجلد
                $imagePath = $image->store('gallery_items', 'public');

                // حفظ الصورة في جدول media
                $media = Media::create([
                    'path' => $imagePath,
                    'type' => 'image',
                    'mime_type' => $image->getClientMimeType(),
                    'width' => getimagesize($image)[0],
                    'height' => getimagesize($image)[1],
                    'size_bytes' => $image->getSize(),
                    'alt_text' => $data['alt_text'],
                    'title' => $data['image_title'],
                ]);

                // إضافة الـ media_id للصورة في البيانات
                $data['image_media_id'] = $media->id;
            }

            // تحديث العنصر
            $galleryItem->update($data);

            return $galleryItem;
        } catch (Throwable $e) {
            throw new \Exception('Error updating gallery item: ' . $e->getMessage());
        }
    }

    // دالة لحذف العنصر بناءً على الـ ID
    public function destroy(int $id): bool
    {
        try {
            $galleryItem = GalleryItem::find($id);
            if (!$galleryItem) {
                throw new \Exception('Gallery item not found.');
            }

            // حذف الصورة المرتبطة إذا كانت موجودة
            if ($galleryItem->image) {
                Storage::disk('public')->delete($galleryItem->image->path);
                $galleryItem->image->delete();
            }

            // حذف العنصر
            return $galleryItem->delete();
        } catch (Throwable $e) {
            throw new \Exception('Error deleting gallery item: ' . $e->getMessage());
        }
    }
}