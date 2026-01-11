<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $bookId = $this->route('book');

        return [
            'title' => 'required|string|max:255',
            'isbn' => [
                'required',
                'string',
                'max:20',
                Rule::unique('books')->ignore($bookId),
            ],
            'description' => 'nullable|string|max:2000',
            'publication_year' => 'nullable|integer|min:1000|max:' . date('Y'),
            'pages' => 'nullable|integer|min:1|max:10000',
            'publisher' => 'nullable|string|max:255',
            'language' => 'required|string|max:10',
            'quantity' => 'required|integer|min:1|max:1000',
            'available_quantity' => 'required|integer|min:0|max:1000|lte:quantity',
            'category_id' => 'required|exists:categories,id',
            'author_ids' => 'required|array|min:1',
            'author_ids.*' => 'exists:authors,id',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'O título é obrigatório.',
            'isbn.required' => 'O ISBN é obrigatório.',
            'isbn.unique' => 'Já existe um livro com este ISBN.',
            'category_id.required' => 'A categoria é obrigatória.',
            'author_ids.required' => 'Selecione pelo menos um autor.',
            'cover_image.max' => 'A capa não pode ser maior que 2MB.',
            'pdf_file.max' => 'O PDF não pode ser maior que 10MB.',
        ];
    }
}