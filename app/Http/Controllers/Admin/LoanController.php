<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Book;
use App\Models\User;
use App\Http\Requests\LoanRequest;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with(['book', 'user'])
            ->latest()
            ->paginate(15);

        return view('admin.loans.index', compact('loans'));
    }

    public function create()
    {
        $books = Book::where('available_quantity', '>', 0)
            ->orderBy('title')
            ->get();
        $users = User::where('role', 'user')
            ->orderBy('name')
            ->get();

        return view('admin.loans.create', compact('books', 'users'));
    }

    public function store(LoanRequest $request)
    {
        $loan = Loan::create($request->validated());

        return redirect()
            ->route('admin.loans.index')
            ->with('success', 'Empréstimo criado com sucesso!');
    }

    public function show(Loan $loan)
    {
        $loan->load(['book.authors', 'user']);

        return view('admin.loans.show', compact('loan'));
    }

    public function edit(Loan $loan)
    {
        $books = Book::orderBy('title')->get();
        $users = User::where('role', 'user')->orderBy('name')->get();

        return view('admin.loans.edit', compact('loan', 'books', 'users'));
    }

    public function update(Request $request, Loan $loan)
    {
        $data = $request->validate([
            'due_date' => 'required|date',
            'notes' => 'nullable|string|max:500',
        ]);

        $loan->update($data);

        return redirect()
            ->route('admin.loans.index')
            ->with('success', 'Empréstimo atualizado com sucesso!');
    }

    public function return(Loan $loan)
    {
        if ($loan->status !== 'active') {
            return redirect()
                ->route('admin.loans.index')
                ->with('error', 'Este empréstimo já foi devolvido.');
        }

        $loan->markAsReturned();

        return redirect()
            ->route('admin.loans.index')
            ->with('success', 'Livro devolvido com sucesso!');
    }

    public function destroy(Loan $loan)
    {
        if ($loan->status === 'active') {
            return redirect()
                ->route('admin.loans.index')
                ->with('error', 'Não é possível eliminar um empréstimo ativo.');
        }

        $loan->delete();

        return redirect()
            ->route('admin.loans.index')
            ->with('success', 'Empréstimo eliminado com sucesso!');
    }
}