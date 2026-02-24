<?php

namespace App\Services;

use App\Models\TestimonialsSection;
use Exception;

class TestimonialsSectionService
{
    public function getAllTestimonialsSections()
    {
        try {
            return TestimonialsSection::all();
        } catch (Exception $e) {
            throw new Exception('Error fetching testimonials sections: ' . $e->getMessage());
        }
    }

    public function updateTestimonialsSection($id, $data)
    {
        try {
            $testimonialsSection = TestimonialsSection::findOrFail($id);
            $testimonialsSection->update($data);
            return $testimonialsSection;
        } catch (Exception $e) {
            throw new Exception('Error updating testimonials section: ' . $e->getMessage());
        }
    }
}