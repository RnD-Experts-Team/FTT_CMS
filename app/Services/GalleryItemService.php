<?php

namespace App\Services;

use App\Models\GalleryItem;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Throwable;
use Illuminate\Support\Facades\DB;
 class GalleryItemService
{
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

     public function index()
    {
        return GalleryItem::with('image')->orderBy('sort_order')->get();
    }

     public function show(int $id): ?GalleryItem
    {
        return GalleryItem::with('image')->find($id);
    }



    public function update(int $id, array $data, $image = null): GalleryItem
    {
        try {
             return DB::transaction(function () use ($id, $data, $image) {
                 $galleryItem = GalleryItem::with('image')->find($id);
                if (!$galleryItem) {
                    throw new \Exception('Gallery item not found.');
                }

                // التحقق من فريدية sort_order
                if (isset($data['sort_order'])) {
                    $so = (int)$data['sort_order'];
                    while (
                        GalleryItem::where('sort_order', $so)
                            ->where('id', '!=', $galleryItem->id)
                            ->exists()
                    ) {
                        $so++;
                    }
                    $data['sort_order'] = $so;
                }

                 if ($image) {
                    // تخزين الصورة الجديدة في المجلد
                    $imagePath = $image->store('gallery_items', 'public');

                    // استخراج الطول والعرض للصورة
                    $imageSize = getimagesize($image);
                    $width = $imageSize[0];
                    $height = $imageSize[1];

                    // حفظ الصورة في جدول media
                    $media = Media::create([
                        'path' => $imagePath,
                        'type' => 'image',
                        'mime_type' => $image->getClientMimeType(),
                        'width' => $width,
                        'height' => $height,
                        'size_bytes' => $image->getSize(),
                        'alt_text' => $data['alt_text'] ?? '',
                        'title' => $data['image_title'] ?? '',
                    ]);

                    // إضافة الـ media_id للصورة الجديدة
                    $data['image_media_id'] = $media->id;
                }

                // تحديث الـ gallery item (دون حذف أي شيء آخر)
                $galleryItem->update($data);

                // بعد اكتمال التحديث، حذف الصورة القديمة
                if ($image && $galleryItem->image) {
                    // حذف الصورة القديمة من التخزين المحلي
                    Storage::disk('public')->delete($galleryItem->image->path);
                    // حذف الصورة من جدول media
                    $galleryItem->image->delete();
                }

                return $galleryItem;
            });
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