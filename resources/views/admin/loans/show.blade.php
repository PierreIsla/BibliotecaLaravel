@extends('layouts.app')

@section('title', 'Detalhes do Empréstimo - Admin')

@section('content')
<div class="max-w-5xl mx-auto px-4">
    <div class="mb-6">
        <a href="{{ route('admin.loans.index') }}" class="text-blue-600 hover:underline">
            ← Voltar para empréstimos
        </a>
    </div>

    <!-- Header com Status -->
    <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-4xl font-bold mb-2">Empréstimo #{{ $loan->id }}</h1>
                <p class="text-gray-600">Criado em {{ $loan->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div class="text-right">
                @if($loan->status === 'active')
                    <span class="inline-block bg-green-100 text-green-800 px-4 py-2 rounded-full text-lg font-semibold mb-2">
                        ✓ Ativo
                    </span>
                    @if($loan->isOverdue())
                        <p class="text-red-600 font-semibold">{{ abs($loan->daysUntilDue()) }} dias de atraso</p>
                    @else
                        <p class="text-gray-600">{{ $loan->daysUntilDue() }} dias restantes</p>
                    @endif
                @elseif($loan->status === 'overdue')
                    <span class="inline-block bg-red-100 text-red-800 px-4 py-2 rounded-full text-lg font-semibold mb-2">
                        ⚠️ Atrasado
                    </span>
                    <p class="text-red-600 font-semibold">{{ abs($loan->daysUntilDue()) }} dias de atraso</p>
                @else
                    <span class="inline-block bg-gray-100 text-gray-800 px-4 py-2 rounded-full text-lg font-semibold mb-2">
                        ✓ Devolvido
                    </span>
                    <p class="text-gray-600">Devolvido em {{ $loan->return_date->format('d/m/Y') }}</p>
                @endif
            </div>
        </div>

        <!-- Informações Principais -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Informações do Livro -->
            <div class="bg-blue-50 p-6 rounded-lg">
                <h2 class="text-xl font-bold mb-4 text-blue-800">📚 Informações do Livro</h2>
                <div class="space-y-3">
                    <div>
                        <span class="text-gray-600 font-semibold">Título:</span>
                        <a href="{{ route('admin.books.show', $loan->book) }}" class="block text-blue-600 hover:underline font-semibold text-lg mt-1">
                            {{ $loan->book->title }}
                        </a>
                    </div>
                    <div>
                        <span class="text-gray-600 font-semibold">Autores:</span>
                        <p class="mt-1">{{ $loan->book->authors->pluck('name')->join(', ') }}</p>
                    </div>
                    <div>
                        <span class="text-gray-600 font-semibold">ISBN:</span>
                        <p class="mt-1 font-mono">{{ $loan->book->isbn }}</p>
                    </div>
                    <div>
                        <span class="text-gray-600 font-semibold">Categoria:</span>
                        <span class="ml-2 bg-blue-100 text-blue-800 px-3 py-1 rounded text-sm">
                            {{ $loan->book->category->name }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Informações do Utilizador -->
            <div class="bg-green-50 p-6 rounded-lg">
                <h2 class="text-xl font-bold mb-4 text-green-800">👤 Informações do Utilizador</h2>
                <div class="space-y-3">
                    <div>
                        <span class="text-gray-600 font-semibold">Nome:</span>
                        <p class="text-lg font-semibold mt-1">{{ $loan->user->name }}</p>
                    </div>
                    <div>
                        <span class="text-gray-600 font-semibold">Email:</span>
                        <a href="mailto:{{ $loan->user->email }}" class="block text-blue-600 hover:underline mt-1">
                            {{ $loan->user->email }}
                        </a>
                    </div>
                    <div>
                        <span class="text-gray-600 font-semibold">Empréstimos Ativos:</span>
                        <p class="mt-1">{{ $loan->user->activeLoans()->count() }}</p>
                    </div>
                    <div>
                        <span class="text-gray-600 font-semibold">Total de Empréstimos:</span>
                        <p class="mt-1">{{ $loan->user->loans()->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Datas do Empréstimo -->
        <div class="mt-8 p-6 bg-gray-50 rounded-lg">
            <h2 class="text-xl font-bold mb-4">📅 Datas</h2>
            <div class="grid grid-cols-3 gap-6">
                <div>
                    <span class="text-gray-600 font-semibold block mb-1">Data de Empréstimo</span>
                    <p class="text-2xl font-bold text-blue-600">{{ $loan->loan_date->format('d/m/Y') }}</p>
                    <p class="text-sm text-gray-500">{{ $loan->loan_date->diffForHumans() }}</p>
                </div>
                <div>
                    <span class="text-gray-600 font-semibold block mb-1">Data de Devolução</span>
                    <p class="text-2xl font-bold {{ $loan->isOverdue() ? 'text-red-600' : 'text-orange-600' }}">
                        {{ $loan->due_date->format('d/m/Y') }}
                    </p>
                    <p class="text-sm text-gray-500">{{ $loan->due_date->diffForHumans() }}</p>
                </div>
                @if($loan->return_date)
                    <div>
                        <span class="text-gray-600 font-semibold block mb-1">Devolvido em</span>
                        <p class="text-2xl font-bold text-green-600">{{ $loan->return_date->format('d/m/Y') }}</p>
                        <p class="text-sm text-gray-500">{{ $loan->return_date->diffForHumans() }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Observações -->
        @if($loan->notes)
            <div class="mt-8 p-6 bg-yellow-50 border-l-4 border-yellow-500 rounded">
                <h3 class="font-semibold mb-2">📝 Observações:</h3>
                <p class="text-gray-700">{{ $loan->notes }}</p>
            </div>
        @endif

        <!-- Ações -->
        <div class="mt-8 flex gap-4">
            @if($loan->status === 'active')
                <form action="{{ route('admin.loans.return', $loan) }}" method="POST" class="inline" onsubmit="return confirm('Confirmar devolução do livro?')">
                    @csrf
                    <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 font-semibold">
                        ✓ Marcar como Devolvido
                    </button>
                </form>
            @endif

            <a href="{{ route('admin.loans.edit', $loan) }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 font-semibold">
                Editar Empréstimo
            </a>

            @if($loan->status !== 'active')
                <form action="{{ route('admin.loans.destroy', $loan) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja eliminar este empréstimo?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 font-semibold">
                        Eliminar Empréstimo
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection