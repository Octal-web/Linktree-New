<?php

namespace App\Http\Requests\Manager;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class OrdemRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'odr' => 'required|array',
            'odr.*.id' => 'required|integer',
            'odr.*.ordem' => 'required|integer',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'odr.required' => 'Por favor, informe a lista de ordens.',
            'odr.array' => 'O formato está inválido.',
            'odr.*.id.required' => 'Por favor, informe a ordem das fotos.',
            'odr.*.ordem.required' => 'A ordem das fotos é um valor inválido!',
        ];
    }
}
