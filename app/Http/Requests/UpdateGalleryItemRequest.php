<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGalleryItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // السماح بتقديم الطلب
    }

    public function rules(): array
    {
        return [
            'gallery_section_id' => 'required|exists:gallery_sections,id',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'alt_text' => 'nullable|string|max:255',
            'image_title' => 'nullable|string|max:255',
            'sort_order' => 'nullable|min:0',  

        ];
    }
}