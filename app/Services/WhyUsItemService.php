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

            if ($icon) {

                $path = $icon->store('icons', 'public');

                $width = 0;
                $height = 0;

                $mime = $icon->getClientMimeType();

                // إذا SVG
                if ($mime === 'image/svg+xml') {

                    [$width, $height] = $this->getSvgDimensions($icon->getPathname());

                } else {

                    // الصور العادية
                    $imageSize = @getimagesize($icon->getPathname());

                    if ($imageSize !== false) {
                        $width = $imageSize[0];
                        $height = $imageSize[1];
                    }
                }

                $media = Media::create([
                    'path' => $path,
                    'type' => 'image',
                    'mime_type' => $mime,
                    'width' => $width,
                    'height' => $height,
                    'size_bytes' => $icon->getSize(),
                    'alt_text' => $data['alt_text'] ?? '',
                    'title' => $data['title'] ?? '',
                ]);

                $data['icon_media_id'] = $media->id;
            }

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
    private function getSvgDimensions(string $filePath): array
    {
        $width = 0;
        $height = 0;

        $content = @file_get_contents($filePath);
        if ($content === false) {
            return [$width, $height];
        }

        $content = preg_replace('/<!DOCTYPE.*?>/si', '', $content);

        $xml = @simplexml_load_string($content);

        if ($xml === false) {
            return [$width, $height];
        }

        $attrs = $xml->attributes();

        // محاولة قراءة width و height مباشرة
        if (isset($attrs['width']) && isset($attrs['height'])) {

            $w = preg_replace('/[^0-9.]+/', '', (string) $attrs['width']);
            $h = preg_replace('/[^0-9.]+/', '', (string) $attrs['height']);

            return [(int)$w, (int)$h];
        }

        // محاولة القراءة من viewBox
        if (isset($attrs['viewBox'])) {

            $viewBox = preg_split('/[\s,]+/', (string) $attrs['viewBox']);

            if (count($viewBox) === 4) {
                return [(int)$viewBox[2], (int)$viewBox[3]];
            }
        }

        return [$width, $height];
    }
}