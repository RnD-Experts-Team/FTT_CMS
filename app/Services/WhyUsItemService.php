<?php

namespace App\Services;

use App\Models\WhyUsItem;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Throwable;

class WhyUsItemService
{
    public function store(array $data, $icon): WhyUsItem
    {
        try {
            // التعامل مع الصورة إذا تم تحميلها
            if ($icon) {
                $path = $icon->store('icons', 'public'); // حفظ الصورة في مجلد icons داخل storage/app/public
                $media = Media::create([
                    'path' => $path,
                    'type' => 'image',
                    'mime_type' => $icon->getClientMimeType(),
                    'width' => getimagesize($icon)[0],
                    'height' => getimagesize($icon)[1],
                    'size_bytes' => $icon->getSize(),
                    'alt_text' => $data['alt_text'] ?? '',
                    'title' => $data['title'] ?? '',
                ]);
                $data['icon_media_id'] = $media->id;
            }

            // التعامل مع قيمة sort_order كما تم شرحه سابقًا
            $existingRecord = WhyUsItem::where('sort_order', $data['sort_order'])->first();
            while ($existingRecord) {
                $data['sort_order'] += 1;
                $existingRecord = WhyUsItem::where('sort_order', $data['sort_order'])->first();
            }

            return WhyUsItem::create($data);
        } catch (Throwable $e) {
            throw new \Exception('Error creating why us item: ' . $e->getMessage());
        }
    }

    public function index()
    {
        return WhyUsItem::with('icon')->orderBy('sort_order')->get();
    }

    public function show(int $id): ?WhyUsItem
    {
        return WhyUsItem::with('icon')->find($id);
    }
    public function update(int $id, array $data, $icon): WhyUsItem
    {
        try {
            $item = WhyUsItem::find($id);
            if (!$item) {
                throw new \Exception('Why us item not found.');
            }

            // التعامل مع الصورة في حال كانت موجودة
            if ($icon) {
                // حذف الصورة القديمة من الـ Storage
                if ($item->icon) {
                    Storage::disk('public')->delete($item->icon->path);
                    $item->icon->delete();
                }

                $path = $icon->store('icons', 'public');
                $media = Media::create([
                    'path' => $path,
                    'type' => 'image',
                    'mime_type' => $icon->getClientMimeType(),
                    'width' => getimagesize($icon)[0],
                    'height' => getimagesize($icon)[1],
                    'size_bytes' => $icon->getSize(),
                    'alt_text' => $data['alt_text'] ?? '',
                    'title' => $data['title'] ?? '',
                ]);
                $data['icon_media_id'] = $media->id;
            }
            $this->ensureUniqueSortOrder($item,$data);
           
            // تحديث السجل بالقيم الجديدة
            $item->update($data);
            return $item;
        } catch (Throwable $e) {
            throw new \Exception('Error updating why us item: ' . $e->getMessage());
        }
    }
     private function ensureUniqueSortOrder(WhyUsItem $item,array &$data)
        {    
            if (!isset($data['sort_order'])) {
                return;
            }

            if ((int) $data['sort_order'] === (int) $item->sort_order) {
                return;
            }

            $existingItem = WhyUsItem::where('sort_order', $data['sort_order'])
                ->where('id', '!=', $item->id)
                ->first();

            while ($existingItem) {
                $data['sort_order'] = (int) $data['sort_order'] + 1;

                $existingItem = WhyUsItem::where('sort_order', $data['sort_order'])
                    ->where('id', '!=', $item->id)
                    ->first();
            }
        

        
        }

    public function destroy(int $id): bool
    {
        try {
            $item = WhyUsItem::find($id);
            if (!$item) {
                throw new \Exception('Why us item not found.');
            }
            
            if ($item->icon) {
                Storage::disk('public')->delete($item->icon->path);
                $item->icon->delete();
            }

            return $item->delete();
        } catch (Throwable $e) {
            throw new \Exception('Error deleting why us item: ' . $e->getMessage());
        }
    }
}