<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NeedsSectionUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'hook' => ['sometimes','required','string','max:255'],
            'title' => ['sometimes','required','string','max:255'],
        ];
    }
}