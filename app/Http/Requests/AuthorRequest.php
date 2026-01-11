<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'biography' => 'nullable|string|max:2000',
            'birth_date' => 'nullable|date|before:today',
            'nationality' => 'nullable|string|max:100',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome do autor é obrigatório.',
            'birth_date.before' => 'A data de nascimento deve ser anterior a hoje.',
            'photo.image' => 'O arquivo deve ser uma imagem.',
            'photo.max' => 'A foto não pode ser maior que 2MB.',
        ];
    }
}