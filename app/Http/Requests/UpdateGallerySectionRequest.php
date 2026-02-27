<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGallerySectionRequest extends FormRequest
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
        ];
    }
}