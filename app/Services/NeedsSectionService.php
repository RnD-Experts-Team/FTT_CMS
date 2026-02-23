<?php

namespace App\Services;

use App\Models\NeedsSection;

class NeedsSectionService
{
    public function index(array $filters)
    {
        $query = NeedsSection::query();

        if (!empty($filters['q'])) {
            $q = $filters['q'];

            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('hook', 'like', "%{$q}%");
            });
        }

        return $query->orderBy('id', 'desc')->get();
    }

    public function update(NeedsSection $section, array $data)
    {
        $section->update($data);
        return $section->refresh();
    }
}