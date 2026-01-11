<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use Illuminate\Http\Request;

class LoanApiController extends Controller
{
    public function index()
    {
        $loans = Loan::with(['book', 'user'])->paginate(15);
        return response()->json($loans);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id',
            'loan_date' => 'required|date',
            'due_date' => 'required|date|after:loan_date',
            'notes' => 'nullable|string',
        ]);

        $loan = Loan::create($validated);
        $loan->load(['book', 'user']);

        return response()->json($loan, 201);
    }

    public function show(Loan $loan)
    {
        $loan->load(['book', 'user']);
        return response()->json($loan);
    }

    public function update(Request $request, Loan $loan)
    {
        $validated = $request->validate([
            'due_date' => 'sometimes|required|date',
            'notes' => 'nullable|string',
        ]);

        $loan->update($validated);
        $loan->load(['book', 'user']);

        return response()->json($loan);
    }

    public function return(Loan $loan)
    {
        if ($loan->status !== 'active') {
            return response()->json([
                'message' => 'Este empréstimo já foi devolvido.'
            ], 422);
        }

        $loan->markAsReturned();
        return response()->json($loan);
    }

    public function destroy(Loan $loan)
    {
        if ($loan->status === 'active') {
            return response()->json([
                'message' => 'Não é possível eliminar um empréstimo ativo.'
            ], 422);
        }

        $loan->delete();
        return response()->json(null, 204);
    }
}