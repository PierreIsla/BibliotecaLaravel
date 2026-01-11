@extends('layouts.app')

@section('title', 'Novo Empréstimo - Admin')

@section('content')
<div class="max-w-3xl mx-auto px-4">
    <div class="mb-6">
        <a href="{{ route('admin.loans.index') }}" class="text-blue-600 hover:underline">
            ← Voltar para empréstimos
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold mb-6">Novo Empréstimo</h1>

        <form action="{{ route('admin.loans.store') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label for="book_id" class="block text-sm font-semibold mb-2">Livro *</label>
                <select 
                    name="book_id" 
                    id="book_id" 
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('book_id') border-red-500 @enderror"
                    required
                >
                    <option value="">Selecione um livro...</option>
                    @foreach($books as $book)
                        <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                            {{ $book->title }} ({{ $book->available_quantity }} disponíveis)
                        </option>
                    @endforeach
                </select>
                @error('book_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="user_id" class="block text-sm font-semibold mb-2">Utilizador *</label>
                <select 
                    name="user_id" 
                    id="user_id" 
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('user_id') border-red-500 @enderror"
                    required
                >
                    <option value="">Selecione um utilizador...</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="loan_date" class="block text-sm font-semibold mb-2">Data de Empréstimo *</label>
                    <input 
                        type="date" 
                        name="loan_date" 
                        id="loan_date" 
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('loan_date') border-red-500 @enderror"
                        value="{{ old('loan_date', date('Y-m-d')) }}"
                        required
                    >
                    @error('loan_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="due_date" class="block text-sm font-semibold mb-2">Data de Devolução *</label>
                    <input 
                        type="date" 
                        name="due_date" 
                        id="due_date" 
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('due_date') border-red-500 @enderror"
                        value="{{ old('due_date', date('Y-m-d', strtotime('+14 days'))) }}"
                        required
                    >
                    @error('due_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="notes" class="block text-sm font-semibold mb-2">Observações</label>
                <textarea 
                    name="notes" 
                    id="notes" 
                    rows="4"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                    placeholder="Notas adicionais sobre o empréstimo..."
                >{{ old('notes') }}</textarea>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 font-semibold">
                    Criar Empréstimo
                </button>
                <a href="{{ route('admin.loans.index') }}" class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-400 font-semibold">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection