<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NeedsItemUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'needs_section_id' => ['sometimes','required','exists:needs_sections,id'],
            'text' => ['sometimes','required','string','max:1024'],
            'sort_order' => ['sometimes','required','integer']
        ];
    }
}