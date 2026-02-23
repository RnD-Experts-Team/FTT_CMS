<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FooterSocialLinkUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'platform' => ['sometimes','required','in:facebook,instagram,linkedin,whatsapp,fountain,indeed'],
            'url' => ['sometimes','required','url','max:1024'],
            'sort_order' => ['sometimes','required','integer'],
            'is_active' => ['sometimes','required','in:0,1'],
        ];
    }
}