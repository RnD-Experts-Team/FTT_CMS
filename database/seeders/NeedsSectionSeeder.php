<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NeedsSection;

class NeedsSectionSeeder extends Seeder
{
    public function run(): void
    {
        NeedsSection::updateOrCreate(
            ['id' => 1],
            [
                'hook' => 'Who Is This For?',
                'title' => 'Designed For Professionals'
            ]
        );

       
    }
}