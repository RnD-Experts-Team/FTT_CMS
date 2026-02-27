<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CtaStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'         => ['required', 'string', 'max:255'],
            'description'   => ['required', 'string'],
            'button1_text'  => ['required', 'string', 'max:100'],
            'button1_link'  => ['required', 'string', 'max:1024'],
            'button2_text'  => ['required', 'string', 'max:100'],
            'button2_link'  => ['required', 'string', 'max:1024'],
            'sort_order'    => ['nullable', 'integer'],
            'is_active'     => ['nullable', 'in:0,1'],
        ];
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key, $default);

        // Defaults مثل الـ DB
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active']  = $data['is_active'] ?? 1;

        return $data;
    }
}