<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTestimonialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'testimonials_section_id' => 'required|exists:testimonials_sections,id',
            'text' => 'required|string|max:1000',
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'duration_seconds' => 'required|integer',
            'sort_order' => 'required|integer',
            'is_active' => 'required|boolean',
            'video' => 'nullable|mimes:mp4,avi|max:50000',  // Max 50MB
            'alt_text' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
        ];
    }
}

 