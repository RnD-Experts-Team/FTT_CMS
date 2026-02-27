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
         // Check if the sort_order is already in use
        $existingItem = FooterSocialLink::where('sort_order', $data['sort_order'])->first();
        
        // If the sort_order already exists, increment it until it's unique
        if ($existingItem) {
            do {
                $data['sort_order'] += 1;
                $existingItem = FooterSocialLink::where('sort_order', $data['sort_order'])->first();
            } while ($existingItem);
        }
        $link->update($data);
        return $link->refresh();
    }
}