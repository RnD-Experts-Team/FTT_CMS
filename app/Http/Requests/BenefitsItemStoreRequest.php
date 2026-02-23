<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BenefitsItemStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'benefits_section_id' => ['required','exists:benefits_sections,id'],
            'text' => ['required','string','max:1024'],
            'sort_order' => ['nullable','integer']
        ];
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key, $default);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        return $data;
    }
}