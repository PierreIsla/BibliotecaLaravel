<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use App\Http\Requests\BookRequest;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with(['category', 'authors'])
            ->latest()
            ->paginate(15);

        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $authors = Author::orderBy('name')->get();

        return view('admin.books.create', compact('categories', 'authors'));
    }

    public function store(BookRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('books/covers', 'public');
        }

        if ($request->hasFile('pdf_file')) {
            $data['pdf_file'] = $request->file('pdf_file')->store('books/pdfs', 'public');
        }

        $authorIds = $data['author_ids'];
        unset($data['author_ids']);

        $book = Book::create($data);
        $book->authors()->attach($authorIds);

        return redirect()
            ->route('admin.books.index')
            ->with('success', 'Livro criado com sucesso!');
    }

    public function show(Book $book)
    {
        $book->load(['category', 'authors', 'loans.user']);

        return view('admin.books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $categories = Category::orderBy('name')->get();
        $authors = Author::orderBy('name')->get();
        $book->load('authors');

        return view('admin.books.edit', compact('book', 'categories', 'authors'));
    }

    public function update(BookRequest $request, Book $book)
    {
        $data = $request->validated();

        if ($request->hasFile('cover_image')) {
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('books/covers', 'public');
        }

        if ($request->hasFile('pdf_file')) {
            if ($book->pdf_file) {
                Storage::disk('public')->delete($book->pdf_file);
            }
            $data['pdf_file'] = $request->file('pdf_file')->store('books/pdfs', 'public');
        }

        $authorIds = $data['author_ids'];
        unset($data['author_ids']);

        $book->update($data);
        $book->authors()->sync($authorIds);

        return redirect()
            ->route('admin.books.index')
            ->with('success', 'Livro atualizado com sucesso!');
    }

    public function destroy(Book $book)
    {
        if ($book->loans()->where('status', 'active')->count() > 0) {
            return redirect()
                ->route('admin.books.index')
                ->with('error', 'Não é possível eliminar um livro com empréstimos ativos.');
        }

        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }
        if ($book->pdf_file) {
            Storage::disk('public')->delete($book->pdf_file);
        }

        $book->delete();

        return redirect()
            ->route('admin.books.index')
            ->with('success', 'Livro eliminado com sucesso!');
    }
}