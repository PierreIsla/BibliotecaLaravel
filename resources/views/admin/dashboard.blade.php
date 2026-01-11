@extends('layouts.app')

@section('title', 'Dashboard Admin - Biblioteca')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold">Dashboard Administrativo</h1>
        <span class="text-gray-600">Bem-vindo, {{ auth()->user()->name }}</span>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-lg border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-semibold uppercase">Total de Livros</p>
                    <p class="text-3xl font-bold text-blue-600 mt-2">{{ $stats['total_books'] }}</p>
                </div>
                <div class="text-blue-500 text-4xl">📚</div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-lg border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-semibold uppercase">Autores</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">{{ $stats['total_authors'] }}</p>
                </div>
                <div class="text-green-500 text-4xl">✍️</div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-lg border-l-4 border-orange-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-semibold uppercase">Empréstimos Ativos</p>
                    <p class="text-3xl font-bold text-orange-600 mt-2">{{ $stats['active_loans'] }}</p>
                </div>
                <div class="text-orange-500 text-4xl">📖</div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-lg border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-semibold uppercase">Atrasados</p>
                    <p class="text-3xl font-bold text-red-600 mt-2">{{ $stats['overdue_loans'] }}</p>
                </div>
                <div class="text-red-500 text-4xl">⚠️</div>
            </div>
        </div>
    </div>

    <!-- Additional Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow">
            <p class="text-gray-500 text-sm font-semibold">Categorias</p>
            <p class="text-2xl font-bold text-gray-800 mt-2">{{ $stats['total_categories'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <p class="text-gray-500 text-sm font-semibold">Utilizadores</p>
            <p class="text-2xl font-bold text-gray-800 mt-2">{{ $stats['total_users'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <p class="text-gray-500 text-sm font-semibold">Livros Disponíveis</p>
            <p class="text-2xl font-bold text-gray-800 mt-2">{{ $stats['available_books'] }}</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold mb-4">Ações Rápidas</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <a href="{{ route('admin.books.create') }}" class="bg-blue-600 text-white p-4 rounded-lg text-center hover:bg-blue-700 transition shadow-lg">
                <div class="text-3xl mb-2">➕</div>
                <div class="font-semibold">Adicionar Livro</div>
            </a>
            <a href="{{ route('admin.authors.create') }}" class="bg-green-600 text-white p-4 rounded-lg text-center hover:bg-green-700 transition shadow-lg">
                <div class="text-3xl mb-2">✍️</div>
                <div class="font-semibold">Adicionar Autor</div>
            </a>
            <a href="{{ route('admin.categories.create') }}" class="bg-purple-600 text-white p-4 rounded-lg text-center hover:bg-purple-700 transition shadow-lg">
                <div class="text-3xl mb-2">📂</div>
                <div class="font-semibold">Adicionar Categoria</div>
            </a>
            <a href="{{ route('admin.loans.create') }}" class="bg-orange-600 text-white p-4 rounded-lg text-center hover:bg-orange-700 transition shadow-lg">
                <div class="text-3xl mb-2">📋</div>
                <div class="font-semibold">Novo Empréstimo</div>
            </a>
        </div>
    </div>

    <!-- Recent Loans -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
        <h2 class="text-2xl font-bold mb-4">Empréstimos Recentes</h2>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b-2 border-gray-200">
                    <tr>
                        <th class="text-left py-3 px-4 font-semibold text-sm">Livro</th>
                        <th class="text-left py-3 px-4 font-semibold text-sm">Utilizador</th>
                        <th class="text-left py-3 px-4 font-semibold text-sm">Data Empréstimo</th>
                        <th class="text-left py-3 px-4 font-semibold text-sm">Data Devolução</th>
                        <th class="text-left py-3 px-4 font-semibold text-sm">Status</th>
                        <th class="text-left py-3 px-4 font-semibold text-sm">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recent_loans as $loan)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4">
                            <a href="{{ route('admin.books.show', $loan->book) }}" class="text-blue-600 hover:underline font-semibold">
                                {{ Str::limit($loan->book->title, 40) }}
                            </a>
                        </td>
                        <td class="py-3 px-4">{{ $loan->user->name }}</td>
                        <td class="py-3 px-4">{{ $loan->loan_date->format('d/m/Y') }}</td>
                        <td class="py-3 px-4">{{ $loan->due_date->format('d/m/Y') }}</td>
                        <td class="py-3 px-4">
                            @if($loan->status === 'active')
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">Ativo</span>
                            @elseif($loan->status === 'overdue')
                                <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-semibold">Atrasado</span>
                            @else
                                <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs font-semibold">Devolvido</span>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            <a href="{{ route('admin.loans.show', $loan) }}" class="text-blue-600 hover:text-blue-800">
                                Ver →
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-8 text-gray-500">
                            Nenhum empréstimo recente
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4 text-center">
            <a href="{{ route('admin.loans.index') }}" class="text-blue-600 hover:underline font-semibold">
                Ver todos os empréstimos →
            </a>
        </div>
    </div>

    <!-- Overdue Loans Alert -->
    @if($overdue_loans->count() > 0)
    <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-6 shadow-lg">
        <div class="flex items-center mb-4">
            <div class="text-red-600 text-3xl mr-3">⚠️</div>
            <h2 class="text-2xl font-bold text-red-800">Empréstimos Atrasados ({{ $overdue_loans->count() }})</h2>
        </div>
        <ul class="space-y-3">
            @foreach($overdue_loans as $loan)
            <li class="bg-white p-4 rounded-lg shadow">
                <div class="flex justify-between items-center">
                    <div>
                        <strong class="text-red-700">{{ $loan->book->title }}</strong>
                        <span class="text-gray-600"> - {{ $loan->user->name }}</span>
                    </div>
                    <div class="text-right">
                        <span class="text-red-600 font-bold">{{ abs($loan->daysUntilDue()) }} dias de atraso</span>
                        <a href="{{ route('admin.loans.show', $loan) }}" class="ml-4 text-blue-600 hover:underline">
                            Ver detalhes
                        </a>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
@endsection