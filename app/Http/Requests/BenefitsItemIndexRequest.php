<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BenefitsItemIndexRequest extends FormRequest
{ 
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'benefits_section_id' => ['nullable', 'exists:benefits_sections,id'],
            'q' => ['nullable','string','max:255'],
        ];
    }
}