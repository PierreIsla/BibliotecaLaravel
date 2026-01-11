<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Http\Requests\AuthorRequest;
use Illuminate\Support\Facades\Storage;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::withCount('books')
            ->latest()
            ->paginate(15);

        return view('admin.authors.index', compact('authors'));
    }

    public function create()
    {
        return view('admin.authors.create');
    }

    public function store(AuthorRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('authors', 'public');
        }

        Author::create($data);

        return redirect()
            ->route('admin.authors.index')
            ->with('success', 'Autor criado com sucesso!');
    }

    public function show(Author $author)
    {
        $author->load(['books' => function($query) {
            $query->with('category')->latest()->take(10);
        }]);

        return view('admin.authors.show', compact('author'));
    }

    public function edit(Author $author)
    {
        return view('admin.authors.edit', compact('author'));
    }

    public function update(AuthorRequest $request, Author $author)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            if ($author->photo) {
                Storage::disk('public')->delete($author->photo);
            }
            $data['photo'] = $request->file('photo')->store('authors', 'public');
        }

        $author->update($data);

        return redirect()
            ->route('admin.authors.index')
            ->with('success', 'Autor atualizado com sucesso!');
    }

    public function destroy(Author $author)
    {
        if ($author->books()->count() > 0) {
            return redirect()
                ->route('admin.authors.index')
                ->with('error', 'Não é possível eliminar um autor com livros associados.');
        }

        if ($author->photo) {
            Storage::disk('public')->delete($author->photo);
        }

        $author->delete();

        return redirect()
            ->route('admin.authors.index')
            ->with('success', 'Autor eliminado com sucesso!');
    }
}