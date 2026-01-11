@extends('layouts.app')

@section('title', 'Meus Empréstimos')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <h1 class="text-4xl font-bold mb-8">Meus Empréstimos</h1>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        @if($loans->count() > 0)
            <table class="w-full">
                <thead class="bg-gray-50 border-b-2 border-gray-200">
                    <tr>
                        <th class="text-left py-4 px-6 font-semibold text-sm">Livro</th>
                        <th class="text-left py-4 px-6 font-semibold text-sm">Data Empréstimo</th>
                        <th class="text-left py-4 px-6 font-semibold text-sm">Data Devolução</th>
                        <th class="text-left py-4 px-6 font-semibold text-sm">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($loans as $loan)
                    <tr class="hover:bg-gray-50">
                        <td class="py-4 px-6">
                            <div class="font-semibold">{{ $loan->book->title }}</div>
                            <div class="text-sm text-gray-600">{{ $loan->book->authors->pluck('name')->join(', ') }}</div>
                        </td>
                        <td class="py-4 px-6 text-gray-600">{{ $loan->loan_date->format('d/m/Y') }}</td>
                        <td class="py-4 px-6 text-gray-600">{{ $loan->due_date->format('d/m/Y') }}</td>
                        <td class="py-4 px-6">
                            @if($loan->status === 'active')
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">
                                    Ativo
                                </span>
                            @elseif($loan->status === 'overdue')
                                <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-semibold">
                                    Atrasado
                                </span>
                            @else
                                <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs font-semibold">
                                    Devolvido
                                </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="text-center py-12 text-gray-500">
                <div class="text-6xl mb-4">📚</div>
                <p class="text-xl">Você ainda não possui empréstimos</p>
            </div>
        @endif
    </div>

    @if($loans->count() > 0)
        <div class="mt-6">
            {{ $loans->links() }}
        </div>
    @endif
</div>
@endsection