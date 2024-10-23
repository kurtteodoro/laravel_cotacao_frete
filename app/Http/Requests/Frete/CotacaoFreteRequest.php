<?php

namespace App\Http\Requests\Frete;

use Illuminate\Foundation\Http\FormRequest;

class CotacaoFreteRequest extends FormRequest
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
            "peso" => ["required", "numeric",],
            "cep" => ["required", "min:10000000", "max:99999999", "numeric"],
            "endereco" => ["required", "min:3", "max:500"],
            "dimensoes.x" => ["required", "numeric", "max: 3000"],
            "dimensoes.y" => ["required", "numeric", "max: 3000"],
            "dimensoes.z" => ["required", "numeric", "max: 3000"],
        ];
    }

    public function messages(): array
    {
        return [
            "peso.required" => "O campo peso é obrigatório (Peso em Gramas)",
            "cep.numeric" => "Cep inválido, o campo cep deve ser um número, envie sormatação",
            "cep.min" => "Cep inválido, o campo cep deve ser um número, envie sormatação",
            "cep.max" => "Cep inválido, o campo cep deve ser um número, envie sormatação",
            "dimensoes.x" => "O campo dimensoes.x é obrigatório e deve ser um número (medida em CM)",
            "dimensoes.y" => "O campo dimensoes.y é obrigatório e deve ser um número (medida em CM)",
            "dimensoes.z" => "O campo dimensoes.z é obrigatório e deve ser um número (medida em CM)",
        ];
    }
}
