<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\LoanController;
use App\Http\Controllers\ProfileController;

// Rotas Públicas (Sem autenticação)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/livros', [HomeController::class, 'books'])->name('books');
Route::get('/livros/{book}', [HomeController::class, 'show'])->name('book.show');
Route::get('/pesquisa', [HomeController::class, 'search'])->name('search');

// Rotas de Autenticação (Laravel Breeze)
require __DIR__.'/auth.php';

// Rota Dashboard (redireciona conforme role)
Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('my.loans');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rotas de Profile (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rotas Administrativas (Requer autenticação + role admin)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Categorias
    Route::resource('categories', CategoryController::class);
    
    // Autores
    Route::resource('authors', AuthorController::class);
    
    // Livros
    Route::resource('books', BookController::class);
    
    // Empréstimos
    Route::resource('loans', LoanController::class);
    Route::post('loans/{loan}/return', [LoanController::class, 'return'])->name('loans.return');
});

// Rotas para Utilizadores Autenticados (não admin)
Route::middleware(['auth', 'role:user'])->prefix('my')->name('my.')->group(function () {
    Route::get('/loans', function() {
        $loans = auth()->user()->loans()->with('book')->latest()->paginate(10);
        return view('user.loans', compact('loans'));
    })->name('loans');
});