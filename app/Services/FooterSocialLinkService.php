<?php

namespace App\Services;

use App\Models\FooterSocialLink;

class FooterSocialLinkService
{
    public function index(array $filters)
    {
        $query = FooterSocialLink::query();

        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }

        return $query->orderBy('sort_order')->get();
    }

    public function update(FooterSocialLink $link, array $data)
    {
        $this->ensureUniqueSortOrder($link, $data);
 
        $link->update($data);
        return $link->refresh();
    }
     private function ensureUniqueSortOrder(FooterSocialLink $link, array &$data): void
    {
         if (!isset($data['sort_order'])) {
            return;
        }

         if ((int) $data['sort_order'] === (int) $link->sort_order) {
            return;
        }

         $existingItem = FooterSocialLink::where('sort_order', $data['sort_order'])
            ->where('id', '!=', $link->id)
            ->first();

        while ($existingItem) {
            $data['sort_order'] = (int) $data['sort_order'] + 1;

            $existingItem = FooterSocialLink::where('sort_order', $data['sort_order'])
                ->where('id', '!=', $link->id)
                ->first();
        }
    }
}