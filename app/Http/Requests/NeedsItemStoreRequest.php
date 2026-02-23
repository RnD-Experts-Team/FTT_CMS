<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NeedsItemStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'needs_section_id' => ['required','exists:needs_sections,id'],
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