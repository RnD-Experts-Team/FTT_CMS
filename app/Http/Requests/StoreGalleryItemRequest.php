<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGalleryItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // السماح بتقديم الطلب
    }

    public function rules(): array
    {
        return [
            'gallery_section_id' => 'required|exists:gallery_sections,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'alt_text' => 'required|string|max:255',
            'image_title' => 'required|string|max:255',
            'sort_order' => 'integer|min:0', // قيمة sort_order يجب أن تكون رقمية

        ];
    }
}