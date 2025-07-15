<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DespesaRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'descricao' => 'required|string|min:3',
            'valor' => 'required|numeric|min:0.01',
            'data' => 'required|date|before_or_equal:today',
        ];
    }

    public function messages(): array
    {
        return [
            'descricao.required' => 'A descrição é obrigatória.',
            'descricao.min' => 'A descrição deve ter no mínimo 3 caracteres.',
            'valor.required' => 'O valor é obrigatório.',
            'valor.min' => 'O valor deve ser maior que zero.',
            'data.required' => 'A data é obrigatória.',
            'data.before_or_equal' => 'A data não pode ser futura.',
        ];
    }
}
