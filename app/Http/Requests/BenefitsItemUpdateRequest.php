<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BenefitsItemUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'benefits_section_id' => ['sometimes','required','exists:benefits_sections,id'],
            'text' => ['sometimes','required','string','max:1024'],
            'sort_order' => ['sometimes','required','integer']
        ];
    }
}