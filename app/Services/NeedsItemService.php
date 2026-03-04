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
       
        $this->ensureUniqueSortOrder($item,$data);
        // تحديث العنصر
        $item->update($data);

        // إعادة العنصر بعد التحديث
        return $item->refresh();
    }
      private function ensureUniqueSortOrder(NeedsItem $item,array &$data)
        {    
            if (!isset($data['sort_order'])) {
                return;
            }

            if ((int) $data['sort_order'] === (int) $item->sort_order) {
                return;
            }

            $existingItem = NeedsItem::where('sort_order', $data['sort_order'])
                ->where('id', '!=', $item->id)
                ->first();

            while ($existingItem) {
                $data['sort_order'] = (int) $data['sort_order'] + 1;

                $existingItem = NeedsItem::where('sort_order', $data['sort_order'])
                    ->where('id', '!=', $item->id)
                    ->first();
            }
        

        
        }

   
   
        public function delete(NeedsItem $item)
    {
        $item->delete();
    }
}