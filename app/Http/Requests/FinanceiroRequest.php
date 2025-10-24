<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FinanceiroRequest extends FormRequest
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
            'salario_mensal' => ['nullable', 'numeric', 'min:0', 'max:9999999999'],
            'limite_alertas' => ['nullable', 'integer', 'min:0', 'max:100'],
        ];
    }
}
