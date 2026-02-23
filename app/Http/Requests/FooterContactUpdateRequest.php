<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FooterContactUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'phone'    => ['sometimes','required','string','max:50'],
            'whatsapp' => ['sometimes','required','string','max:50'],
            'email'    => ['sometimes','required','email','max:255'],
            'address'  => ['sometimes','required','string'],
        ];
    }
}