<?php

namespace Database\Seeders;

use App\Models\GallerySection;
use Illuminate\Database\Seeder;

class GallerySectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GallerySection::create([
            'hook' => 'artworks',
            'title' => 'Art Gallery',
            'description' => 'This section showcases amazing artworks from various artists.',
        ]);

     
    }
}