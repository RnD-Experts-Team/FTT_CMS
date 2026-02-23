<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CtaUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function rules(): array
    {
        return [
            'title'         => ['sometimes', 'required', 'string', 'max:255'],
            'description'   => ['sometimes', 'required', 'string'],
            'button1_text'  => ['sometimes', 'required', 'string', 'max:100'],
            'button1_link'  => ['sometimes', 'required', 'string', 'max:1024'],
            'button2_text'  => ['sometimes', 'required', 'string', 'max:100'],
            'button2_link'  => ['sometimes', 'required', 'string', 'max:1024'],
            'sort_order'    => ['sometimes', 'required', 'integer'],
            'is_active'     => ['sometimes', 'required', 'in:0,1'],
        ];
    }
}
