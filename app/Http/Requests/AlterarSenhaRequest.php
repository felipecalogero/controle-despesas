<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class AlterarSenhaRequest extends FormRequest
{
    public function rules()
    {
        $user = auth()->user();
        $rules = [
            'nova_senha' => 'required|min:8|confirmed',
        ];

        // Só valida senha atual se usuário já tiver senha
        if (!empty($user->password)) {
            $rules['senha_atual'] = ['required', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    $fail('A senha atual está incorreta.');
                }
            }];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'senha_atual.required' => 'Para alterar a senha, precisamos confirmar sua identidade.',
            'nova_senha.required' => 'A nova senha é obrigatória.',
            'nova_senha.min' => 'Use pelo menos 8 caracteres para sua segurança.',
            'nova_senha.confirmed' => 'As senhas não coincidem.',
        ];
    }
}
