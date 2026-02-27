<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HeroSectionUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // يمكنك تعديلها إذا كنت تريد تحديد من يحق له تعديل البيانات
    }

    public function rules(): array
    {
        return [
            // تحقق من الحقول النصية
            'subheader' => ['sometimes', 'required', 'string', 'max:255'],
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'description_html' => ['sometimes', 'required', 'string'],
            'button1_text' => ['sometimes', 'required', 'string', 'max:100'],
            'button1_link' => ['sometimes', 'required', 'string', 'max:1024'],
            'button2_text' => ['sometimes', 'required', 'string', 'max:100'],
            'button2_link' => ['sometimes', 'required', 'string', 'max:1024'],

            // تحقق من الـ media_files
            'media_files' => ['sometimes', 'array'],
            'media_files.*' => ['file', 'mimes:jpg,jpeg,png,mp4,mov', 'max:51200'], // قيود حجم الملف 50MB

            // تحقق من الـ sort_orders
            'sort_orders' => ['sometimes', 'array'],
            'sort_orders.*' => ['nullable', 'integer', 'min:0'], // تحقق من أن الـ sort_orders هي أرقام صحيحة

            // تحقق من الـ alt_text و title_text
            'alt_text' => ['sometimes', 'array'],
            'alt_text.*' => ['nullable', 'string', 'max:255'], // تحقق من النص البديل لكل media
            'title_text' => ['sometimes', 'array'],
            'title_text.*' => ['nullable', 'string', 'max:255'], // تحقق من العنوان لكل media
        ];
    }

    /**
     * التحقق من البيانات قبل تقديمها.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // تحقق من أن عدد العناصر في media_files و sort_orders و alt_text و title_text متساويين
            if (isset($this->media_files) && isset($this->sort_orders) && isset($this->alt_text) && isset($this->title_text)) {
                if (count($this->media_files) !== count($this->sort_orders) || 
                    count($this->media_files) !== count($this->alt_text) || 
                    count($this->media_files) !== count($this->title_text)) {
                    $validator->errors()->add('media_files', 'The number of media files, sort orders, alt text, and titles must match.');
                }
            }
        });
    }
}