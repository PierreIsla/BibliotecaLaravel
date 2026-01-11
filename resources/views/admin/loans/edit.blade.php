@extends('layouts.app')

@section('title', 'Editar Empréstimo - Admin')

@section('content')
<div class="max-w-3xl mx-auto px-4">
    <div class="mb-6">
        <a href="{{ route('admin.loans.index') }}" class="text-blue-600 hover:underline">
            ← Voltar para empréstimos
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold mb-6">Editar Empréstimo #{{ $loan->id }}</h1>

        <!-- Info do Empréstimo -->
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <p class="font-semibold text-lg">{{ $loan->book->title }}</p>
                    <p class="text-gray-600">Emprestado para: {{ $loan->user->name }}</p>
                </div>
                <div class="text-right">
                    @if($loan->status === 'active')
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                            Ativo
                        </span>
                    @elseif($loan->status === 'overdue')
                        <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold">
                            Atrasado
                        </span>
                    @else
                        <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm font-semibold">
                            Devolvido
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <form action="{{ route('admin.loans.update', $loan) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="due_date" class="block text-sm font-semibold mb-2">Data de Devolução *</label>
                <input 
                    type="date" 
                    name="due_date" 
                    id="due_date" 
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('due_date') border-red-500 @enderror"
                    value="{{ old('due_date', $loan->due_date->format('Y-m-d')) }}"
                    required
                >
                @error('due_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">Data original: {{ $loan->due_date->format('d/m/Y') }}</p>
            </div>

            <div class="mb-6">
                <label for="notes" class="block text-sm font-semibold mb-2">Observações</label>
                <textarea 
                    name="notes" 
                    id="notes" 
                    rows="4"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                    placeholder="Notas adicionais sobre o empréstimo..."
                >{{ old('notes', $loan->notes) }}</textarea>
            </div>

            <!-- Info adicional -->
            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <h3 class="font-semibold mb-3">Informações do Empréstimo</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-600">Data de Empréstimo:</span>
                        <span class="ml-2 font-semibold">{{ $loan->loan_date->format('d/m/Y') }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Status:</span>
                        <span class="ml-2 font-semibold">{{ ucfirst($loan->status) }}</span>
                    </div>
                    @if($loan->return_date)
                        <div>
                            <span class="text-gray-600">Devolvido em:</span>
                            <span class="ml-2 font-semibold">{{ $loan->return_date->format('d/m/Y') }}</span>
                        </div>
                    @endif
                    @if($loan->isOverdue())
                        <div>
                            <span class="text-red-600 font-semibold">Dias de atraso:</span>
                            <span class="ml-2 text-red-600 font-bold">{{ abs($loan->daysUntilDue()) }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 font-semibold">
                    Atualizar Empréstimo
                </button>
                <a href="{{ route('admin.loans.index') }}" class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-400 font-semibold">
                    Cancelar
                </a>
            </div>
        </form>

        <!-- Ação de Devolução -->
        @if($loan->status === 'active')
            <div class="mt-8 pt-8 border-t">
                <h3 class="text-xl font-bold mb-4">Registar Devolução</h3>
                <form action="{{ route('admin.loans.return', $loan) }}" method="POST" onsubmit="return confirm('Confirmar devolução do livro?')">
                    @csrf
                    <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 font-semibold">
                        ✓ Marcar como Devolvido
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection