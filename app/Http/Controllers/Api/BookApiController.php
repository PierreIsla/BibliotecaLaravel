<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookApiController extends Controller
{
    public function index()
    {
        $books = Book::with(['category', 'authors'])->paginate(15);
        return response()->json($books);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books',
            'description' => 'nullable|string',
            'publication_year' => 'nullable|integer',
            'pages' => 'nullable|integer',
            'publisher' => 'nullable|string',
            'language' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'available_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'author_ids' => 'required|array|min:1',
            'author_ids.*' => 'exists:authors,id',
        ]);

        $authorIds = $validated['author_ids'];
        unset($validated['author_ids']);

        $book = Book::create($validated);
        $book->authors()->attach($authorIds);
        $book->load(['category', 'authors']);

        return response()->json($book, 201);
    }

    public function show(Book $book)
    {
        $book->load(['category', 'authors', 'loans']);
        return response()->json($book);
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'isbn' => 'sometimes|required|string|unique:books,isbn,' . $book->id,
            'description' => 'nullable|string',
            'publication_year' => 'nullable|integer',
            'pages' => 'nullable|integer',
            'publisher' => 'nullable|string',
            'language' => 'sometimes|required|string',
            'quantity' => 'sometimes|required|integer|min:1',
            'available_quantity' => 'sometimes|required|integer|min:0',
            'category_id' => 'sometimes|required|exists:categories,id',
            'author_ids' => 'sometimes|required|array|min:1',
            'author_ids.*' => 'exists:authors,id',
        ]);

        if (isset($validated['author_ids'])) {
            $authorIds = $validated['author_ids'];
            unset($validated['author_ids']);
            $book->authors()->sync($authorIds);
        }

        $book->update($validated);
        $book->load(['category', 'authors']);

        return response()->json($book);
    }

    public function destroy(Book $book)
    {
        if ($book->loans()->where('status', 'active')->count() > 0) {
            return response()->json([
                'message' => 'Não é possível eliminar um livro com empréstimos ativos.'
            ], 422);
        }

        $book->delete();
        return response()->json(null, 204);
    }
}