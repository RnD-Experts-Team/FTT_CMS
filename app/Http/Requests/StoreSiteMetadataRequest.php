<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSiteMetadataRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // السماح بتقديم الطلب
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'keywords' => 'required|string|max:1024',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'logo_alt_text' => 'nullable|string|max:255',
            'logo_title' => 'nullable|string|max:255',
            'favicon_alt_text' => 'nullable|string|max:255',
            'favicon_title' => 'nullable|string|max:255',
        ];
    }
}