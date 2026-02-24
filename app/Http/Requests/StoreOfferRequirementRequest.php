<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOfferRequirementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // السماح بتقديم الطلب
    }

    public function rules(): array
    {
        return [
            'offer_section_id' => 'required|exists:offer_sections,id',
            'text' => 'required|string|max:1024',
            'sort_order' => 'integer|min:0', // قيمة sort_order يجب أن تكون رقمية
        ];
    }
}