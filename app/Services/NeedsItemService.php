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
        return NeedsItem::create($data);
    }

    public function update(NeedsItem $item, array $data)
    {
        $item->update($data);
        return $item->refresh();
    }

    public function delete(NeedsItem $item)
    {
        $item->delete();
    }
}