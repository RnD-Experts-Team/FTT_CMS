<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CtaIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // عندك auth:sanctum على الراوت
    }

    public function rules(): array
    {
        return [
            'is_active' => ['nullable', 'in:0,1'],
            'q'         => ['nullable', 'string', 'max:255'],
            'sort_by'   => ['nullable', 'in:id,sort_order,title,created_at,updated_at'],
            'sort_dir'  => ['nullable', 'in:asc,desc'],
            'per_page'  => ['nullable', 'integer', 'min:1', 'max:200'],
        ];
    }
}