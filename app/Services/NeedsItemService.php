<?php

namespace App\Services;

use App\Models\NeedsItem;

class NeedsItemService
{
    public function index(array $filters)
    {
        $query = NeedsItem::query();

        if (!empty($filters['needs_section_id'])) {
            $query->where('needs_section_id', $filters['needs_section_id']);
        }

        if (!empty($filters['q'])) {
            $query->where('text', 'like', '%' . $filters['q'] . '%');
        }

        return $query->orderBy('sort_order')->get();
    }

    public function show(NeedsItem $item)
    {
        return $item;
    }

   public function create(array $data)
    {
        // Check if the sort_order is already in use
        $existingItem = NeedsItem::where('sort_order', $data['sort_order'])->first();
        
        // If the sort_order already exists, increment it until it's unique
        if ($existingItem) {
            do {
                $data['sort_order'] += 1;
                $existingItem = NeedsItem::where('sort_order', $data['sort_order'])->first();
            } while ($existingItem);
        }

        // Create the new NeedsItem with the unique sort_order
        return NeedsItem::create($data);
    }
  public function update(NeedsItem $item, array $data)
    {
        // تحقق من أن sort_order تم تغييره
        if (isset($data['sort_order']) && $data['sort_order'] != $item->sort_order) {
            // تحقق إذا كان sort_order الجديد موجود
            $existingItem = NeedsItem::where('sort_order', $data['sort_order'])->first();
            
            // إذا كان موجودًا، قم بزيادة القيمة حتى تصبح فريدة
            if ($existingItem) {
                do {
                    $data['sort_order'] += 1;
                    $existingItem = NeedsItem::where('sort_order', $data['sort_order'])->first();
                } while ($existingItem);
            }
        }

        // تحديث العنصر
        $item->update($data);

        // إعادة العنصر بعد التحديث
        return $item->refresh();
    }

    public function delete(NeedsItem $item)
    {
        $item->delete();
    }
}