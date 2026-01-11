@extends('layouts.app')

@section('title', 'Empréstimos - Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold">Gestão de Empréstimos</h1>
        <a href="{{ route('admin.loans.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 font-semibold shadow-lg">
            ➕ Novo Empréstimo
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b-2 border-gray-200">
                <tr>
                    <th class="text-left py-4 px-6 font-semibold text-sm">ID</th>
                    <th class="text-left py-4 px-6 font-semibold text-sm">Livro</th>
                    <th class="text-left py-4 px-6 font-semibold text-sm">Utilizador</th>
                    <th class="text-left py-4 px-6 font-semibold text-sm">Data Empréstimo</th>
                    <th class="text-left py-4 px-6 font-semibold text-sm">Data Devolução</th>
                    <th class="text-left py-4 px-6 font-semibold text-sm">Status</th>
                    <th class="text-right py-4 px-6 font-semibold text-sm">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($loans as $loan)
                <tr class="hover:bg-gray-50">
                    <td class="py-4 px-6">{{ $loan->id }}</td>
                    <td class="py-4 px-6">
                        <a href="{{ route('admin.books.show', $loan->book) }}" class="text-blue-600 hover:underline font-semibold">
                            {{ Str::limit($loan->book->title, 40) }}
                        </a>
                    </td>
                    <td class="py-4 px-6">{{ $loan->user->name }}</td>
                    <td class="py-4 px-6 text-gray-600">{{ $loan->loan_date->format('d/m/Y') }}</td>
                    <td class="py-4 px-6 text-gray-600">{{ $loan->due_date->format('d/m/Y') }}</td>
                    <td class="py-4 px-6">
                        @if($loan->status === 'active')
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">
                                Ativo
                            </span>
                        @elseif($loan->status === 'overdue')
                            <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-semibold">
                                Atrasado ({{ abs($loan->daysUntilDue()) }}d)
                            </span>
                        @else
                            <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs font-semibold">
                                Devolvido
                            </span>
                        @endif
                    </td>
                    <td class="py-4 px-6 text-right">
                        <a href="{{ route('admin.loans.show', $loan) }}" class="text-blue-600 hover:text-blue-800 mr-3">
                            Ver
                        </a>
                        
                        @if($loan->status === 'active')
                            <form action="{{ route('admin.loans.return', $loan) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-green-600 hover:text-green-800 mr-3">
                                    Devolver
                                </button>
                            </form>
                        @endif
                        
                        <a href="{{ route('admin.loans.edit', $loan) }}" class="text-orange-600 hover:text-orange-800 mr-3">
                            Editar
                        </a>
                        
                        @if($loan->status !== 'active')
                            <form action="{{ route('admin.loans.destroy', $loan) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">
                                    Eliminar
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-12 text-gray-500">
                        <div class="text-6xl mb-4">📋</div>
                        Nenhum empréstimo encontrado
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $loans->links() }}
    </div>
</div>
@endsection
