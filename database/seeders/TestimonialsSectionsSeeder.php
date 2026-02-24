<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TestimonialsSection;

class TestimonialsSectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         
            TestimonialsSection::updateOrCreate([
                'hook' => 'Our Happy Customers',
                'title' => 'What People Are Saying',
                'description' => 'This section contains testimonials from our customers who are satisfied with our services.',
            ]);
    }
        
}