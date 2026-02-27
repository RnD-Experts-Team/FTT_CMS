<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TemptationSectionUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // إذا كنت تريد السماح بتقديم الطلب
    }

    public function rules(): array
    {
        return [
            'hook' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'button1_text' => 'required|string|max:100',
            'button1_link' => 'required|string|max:1024',
            'button2_text' => 'required|string|max:100',
            'button2_link' => 'required|string|max:1024',
            'image' => 'nullable|file|mimes:jpg,jpeg,png|max:51200',
            'image_title' => 'nullable|string|max:255',
            'image_alt_text' => 'nullable|string|max:255',
        ];
    }
}