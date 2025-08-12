<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CadastroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required|min:3',
            'verify_password' => 'required|same:password',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Favor inserir seu nome',
            'last_name.required' => 'Favor inserir seu sobrenome',
            'email.required' => 'Favor inserir seu email',
            'password.required' => 'Favor inserir sua senha',
            'verify_password.required' => 'Favor confirmar sua senha',
            'verify_password.same' => 'As senhas não são iguais',
        ];
    }
}
