<?php

namespace App\Services;

use App\Models\HeroSection;

class HeroSectionService
{
    public function index()
    {
        return HeroSection::with('media')->orderBy('id','desc')->get();
    }

    public function update(HeroSection $section, array $data)
    {
        $section->update($data);
        return $section->refresh();
    }
}