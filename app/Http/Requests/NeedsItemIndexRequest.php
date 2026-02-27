<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NeedsItemIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'needs_section_id' => ['nullable', 'exists:needs_sections,id'],
            'q' => ['nullable','string','max:1024'],
        ];
    }
}