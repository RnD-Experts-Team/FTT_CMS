<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TemptationRequirementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // السماح بتقديم الطلب
    }

    public function rules(): array
    {
        return [
            'temptation_section_id' => 'required|exists:temptation_sections,id',
            'text' => 'required|string|max:1024',
            'sort_order' => 'integer|min:0',
        ];
    }
}