<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOfferSectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // السماح بتقديم الطلب
    }

    public function rules(): array
    {
        return [
            'hook' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'button_text' => 'required|string|max:100',
            'button_link' => 'required|string|max:1024',
            'alt_text' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // التحقق من الصورة إذا كانت موجودة
            'image_title' => 'nullable|string|max:255',
        ];
    }
}