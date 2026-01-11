<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Book;

class LoanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'book_id' => [
                'required',
                'exists:books,id',
                function ($attribute, $value, $fail) {
                    $book = Book::find($value);
                    if ($book && !$book->isAvailable()) {
                        $fail('Este livro não está disponível para empréstimo.');
                    }
                },
            ],
            'user_id' => 'required|exists:users,id',
            'loan_date' => 'required|date',
            'due_date' => 'required|date|after:loan_date',
            'notes' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'book_id.required' => 'Selecione um livro.',
            'user_id.required' => 'Selecione um utilizador.',
            'due_date.after' => 'A data de devolução deve ser posterior à data de empréstimo.',
        ];
    }
}