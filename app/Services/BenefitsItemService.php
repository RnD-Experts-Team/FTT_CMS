<?php

namespace App\Services;

use App\Models\BenefitsItem;

class BenefitsItemService
{
    public function index(array $filters)
    {
        $query = BenefitsItem::query();

        if (!empty($filters['benefits_section_id'])) {
            $query->where('benefits_section_id', $filters['benefits_section_id']);
        }

        if (!empty($filters['q'])) {
            $query->where('text', 'like', '%' . $filters['q'] . '%');
        }

        return $query->orderBy('sort_order')->get();
    }

    public function show(BenefitsItem $item)
    {
        return $item;
    }

    public function create(array $data)
    {
        $this->ensureUniqueSortOrder($data);
        return BenefitsItem::create($data);
    }

    public function update(BenefitsItem $item, array $data)
    {
        $this->ensureUniqueSortOrder($data);
        $item->update($data);
        return $item->refresh();
    }

    public function delete(BenefitsItem $item)
    {
        $item->delete();
    }
    private function ensureUniqueSortOrder(array &$data)
    {
        // Check if the sort_order is already in use
        $existingItem = BenefitsItem::where('sort_order', $data['sort_order'])->first();
        
        // If the sort_order already exists, increment it until it's unique
        if ($existingItem) {
            do {
                $data['sort_order'] += 1;
                $existingItem = BenefitsItem::where('sort_order', $data['sort_order'])->first();
            } while ($existingItem);
        }
    }
}