<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules() {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8'],
        ];
    }

    public function messages() {
        return [
            'email.required' => 'Favor adicionar um email válido.',
            'password.required' => 'Favor adicionar uma senha.',
        ];
    }
}
