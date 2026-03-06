<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;  
    }

    public function rules()
    {
        return [
            'email' => 'nullable|email',  
            'name' => 'nullable|string|max:255',  
            'password' => 'nullable|string|min:8', 
        ];
    }
}
