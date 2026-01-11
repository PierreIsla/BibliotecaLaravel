<?php

namespace Database\Seeders;

use App\Models\Loan;
use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class LoanSeeder extends Seeder
{
    public function run(): void
    {
        // Buscar utilizadores e livros existentes
        $users = User::where('role', 'user')->get();
        $books = Book::all();

        if ($users->isEmpty() || $books->isEmpty()) {
            return; // Não criar empréstimos se não houver users ou livros
        }

        // Empréstimo 1 - Ativo
        $book1 = $books->random();
        $book1->decrementAvailable();
        Loan::create([
            'book_id' => $book1->id,
            'user_id' => $users->random()->id,
            'loan_date' => Carbon::now()->subDays(5),
            'due_date' => Carbon::now()->addDays(9),
            'status' => 'active',
            'notes' => 'Empréstimo regular',
        ]);

        // Empréstimo 2 - Ativo
        $book2 = $books->random();
        $book2->decrementAvailable();
        Loan::create([
            'book_id' => $book2->id,
            'user_id' => $users->random()->id,
            'loan_date' => Carbon::now()->subDays(3),
            'due_date' => Carbon::now()->addDays(11),
            'status' => 'active',
        ]);

        // Empréstimo 3 - Atrasado
        $book3 = $books->random();
        $book3->decrementAvailable();
        Loan::create([
            'book_id' => $book3->id,
            'user_id' => $users->random()->id,
            'loan_date' => Carbon::now()->subDays(20),
            'due_date' => Carbon::now()->subDays(6),
            'status' => 'overdue',
            'notes' => 'Empréstimo em atraso - contactar utilizador',
        ]);

        // Empréstimo 4 - Devolvido
        $book4 = $books->random();
        Loan::create([
            'book_id' => $book4->id,
            'user_id' => $users->random()->id,
            'loan_date' => Carbon::now()->subDays(30),
            'due_date' => Carbon::now()->subDays(16),
            'return_date' => Carbon::now()->subDays(17),
            'status' => 'returned',
            'notes' => 'Devolvido em bom estado',
        ]);

        // Empréstimo 5 - Devolvido
        $book5 = $books->random();
        Loan::create([
            'book_id' => $book5->id,
            'user_id' => $users->random()->id,
            'loan_date' => Carbon::now()->subDays(45),
            'due_date' => Carbon::now()->subDays(31),
            'return_date' => Carbon::now()->subDays(30),
            'status' => 'returned',
        ]);

        // Empréstimo 6 - Ativo
        $book6 = $books->random();
        $book6->decrementAvailable();
        Loan::create([
            'book_id' => $book6->id,
            'user_id' => $users->random()->id,
            'loan_date' => Carbon::now()->subDays(7),
            'due_date' => Carbon::now()->addDays(7),
            'status' => 'active',
        ]);
    }
}