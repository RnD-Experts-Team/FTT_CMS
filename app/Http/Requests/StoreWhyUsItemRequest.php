<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWhyUsItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // السماح بتقديم الطلب
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'sort_order' => 'integer|min:0',
            'is_active' => 'required|boolean',
            'alt_text' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // للتأكد من أن الصورة تم تحميلها بشكل صحيح
        ];
    }
}