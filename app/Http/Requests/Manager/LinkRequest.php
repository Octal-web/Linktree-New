<?php

namespace App\Http\Requests\Manager;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class LinkRequest extends FormRequest
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
        $rules = [
            'titulo' => 'required|string',
            'link' => 'required|url',
        ];

        if ($this->routeIs('Manager.Links.novo')) {
            $rules['imagem'] = 'required|image|mimes:png,jpg,jpeg|max:2048';
        } elseif ($this->hasFile('imagem')) {
            $rules['imagem'] = 'nullable|image|mimes:png,jpg,jpeg|max:2048';
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'titulo.required' => 'O título é obrigatório.',

            'link.required' => 'O link é obrigatório.',
            'link.url' => 'O link deve ser uma URL válida.',

            'imagem.required' => 'A imagem é obrigatória.',
            'imagem.image' => 'O arquivo deve ser uma imagem.',
            'imagem.mimes' => 'A imagem deve ser do tipo PNG ou JPG.',
            'imagem.max' => 'A imagem não pode ser maior que 2MB.',
        ];
    }
}
