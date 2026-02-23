<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FooterSocialLink;

class FooterSocialLinkSeeder extends Seeder
{
    public function run(): void
    {
        $links = [
            [
                'platform' => 'facebook',
                'url' => 'https://facebook.com/yourpage',
                'sort_order' => 1,
                'is_active' => 1,
            ],
            [
                'platform' => 'instagram',
                'url' => 'https://instagram.com/yourpage',
                'sort_order' => 2,
                'is_active' => 1,
            ],
            [
                'platform' => 'linkedin',
                'url' => 'https://linkedin.com/company/yourcompany',
                'sort_order' => 3,
                'is_active' => 1,
            ],
        ];

        foreach ($links as $link) {
            FooterSocialLink::updateOrCreate(
                ['platform' => $link['platform']],
                $link
            );
        }
    }
}