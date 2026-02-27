<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FooterSocialLinkIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'is_active' => ['nullable','in:0,1'],
        ];
    }
}