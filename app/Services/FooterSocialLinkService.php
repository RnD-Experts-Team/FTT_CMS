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
        $link->update($data);
        return $link->refresh();
    }
}