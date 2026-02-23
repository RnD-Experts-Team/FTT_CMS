<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BenefitsSection;

class BenefitsSectionSeeder extends Seeder
{
    public function run(): void
    {
        BenefitsSection::updateOrCreate(
            ['id' => 1],
            [
                'hook' => 'Why Choose Us',
                'title' => 'Our Key Benefits'
            ]
        );

 
    }
}