<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HeroSectionUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'subheader' => ['sometimes','required','string','max:255'],
            'title' => ['sometimes','required','string','max:255'],
            'description_html' => ['sometimes','required','string'],
            'button1_text' => ['sometimes','required','string','max:100'],
            'button1_link' => ['sometimes','required','string','max:1024'],
            'button2_text' => ['sometimes','required','string','max:100'],
            'button2_link' => ['sometimes','required','string','max:1024'],

             'media_files' => ['sometimes','array'],
            'media_files.*' => ['file','mimes:jpg,jpeg,png,mp4,mov','max:51200'],

            'sort_orders' => ['sometimes','array'],
            'sort_orders.*' => ['nullable','integer','min:0'],
         ];
    }
}