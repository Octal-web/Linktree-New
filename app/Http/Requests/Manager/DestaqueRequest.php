<?php

namespace App\Http\Requests\Manager;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class DestaqueRequest extends FormRequest
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
            'conteudo' => 'required|string|min:10|max:300',
            'link' => 'required|url',
            'cor_bg' => 'nullable|string|max:20',
            'cor_texto' => 'nullable|string|max:20',
            'formato' => 'required|in:imagem_texto_sobreposto,bloco_e_imagem,imagem_e_bloco',
        ];

        if ($this->routeIs('Manager.Destaques.novo')) {
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
            'titulo.string' => 'O titulo é inválido.',
            'titulo.required' => 'O titulo é obrigatório.',

            'conteudo.required' => 'O texto é obrigatório.',
            'conteudo.string' => 'O texto é inválido.',
            'conteudo.min' => 'O texto deve ter no mínimo 10 caracteres.',
            'conteudo.max' => 'O texto não pode ter mais que 300 caracteres.',

            'link.required' => 'O link é obrigatório.',
            'link.url' => 'O link deve ser uma URL válida.',

            'cor_bg.string' => 'A cor de fundo é inválida.',
            'cor_bg.max' => 'A cor de fundo não pode ter mais que 20 caracteres.',

            'cor_texto.string' => 'A cor do texto é inválida.',
            'cor_texto.max' => 'A cor do texto não pode ter mais que 20 caracteres.',

            'formato.required' => 'O formato é obrigatório.',
            'formato.in' => 'O formato é inválido.',

            'imagem.required' => 'A imagem é obrigatória.',
            'imagem.image' => 'O arquivo deve ser uma imagem.',
            'imagem.mimes' => 'A imagem deve ser do tipo PNG ou JPG.',
            'imagem.max' => 'A imagem não pode ser maior que 2MB.',
        ];
    }
}
