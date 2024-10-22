<?php

namespace App\Http\Requests\Usuario;

use Illuminate\Foundation\Http\FormRequest;

class CadastrarUsuarioRequest extends FormRequest
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
            "email" => ["email", "required", "min:5", "max:200", "unique:users"],
            "password" => ["required", "min:5", "max:200"],
            "name" => ["required", "alpha", "min:5", "max:200"],
        ];
    }

    public function messages(): array
    {
        return [
            "password.required" => "O campo password é obrigatório"
        ];
    }
}
