<?php

namespace App\Services;

use App\Models\BenefitsSection;

class BenefitsSectionService
{
  public function index(array $filters)
    {
        $query = BenefitsSection::query();

        if (!empty($filters['q'])) {
            $q = $filters['q'];

            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('hook', 'like', "%{$q}%");
            });
        }

        // ترتيب اختياري (مفيد)
        $query->orderBy('id', 'desc');

        return $query->get();
    }

    public function show(BenefitsSection $section)
    {
        return $section;
    }

    public function update(BenefitsSection $section, array $data)
    {
        $section->update($data);
        return $section->refresh();
    }
}