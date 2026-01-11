<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\AuthorApiController;
use App\Http\Controllers\Api\LoanApiController;

// Rotas públicas
Route::post('/login', [AuthController::class, 'login']);

// Rotas protegidas (requerem autenticação)
Route::middleware('auth:sanctum')->group(function () {
    
    // Autenticação
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    
    // Books
    Route::apiResource('books', BookApiController::class);
    
    // Categories
    Route::apiResource('categories', CategoryApiController::class);
    
    // Authors
    Route::apiResource('authors', AuthorApiController::class);
    
    // Loans
    Route::apiResource('loans', LoanApiController::class);
    Route::post('loans/{loan}/return', [LoanApiController::class, 'return']);
});