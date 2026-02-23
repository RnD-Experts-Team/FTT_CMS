<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FounderSectionUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'hook_text' => ['sometimes','required','string','max:255'],
            'title' => ['sometimes','required','string','max:255'],
            'description' => ['sometimes','required','string'],
            'video' => ['sometimes','file','mimes:mp4,mov,avi','max:51200'] // 50MB
        ];
    }
}