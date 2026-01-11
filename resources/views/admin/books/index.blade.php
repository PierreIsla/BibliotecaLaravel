@extends('layouts.app')

@section('title', 'Livros - Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold">Gestão de Livros</h1>
        <a href="{{ route('admin.books.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 font-semibold shadow-lg">
            ➕ Novo Livro
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b-2 border-gray-200">
                <tr>
                    <th class="text-left py-4 px-6 font-semibold text-sm">ID</th>
                    <th class="text-left py-4 px-6 font-semibold text-sm">Título</th>
                    <th class="text-left py-4 px-6 font-semibold text-sm">Autores</th>
                    <th class="text-left py-4 px-6 font-semibold text-sm">Categoria</th>
                    <th class="text-left py-4 px-6 font-semibold text-sm">ISBN</th>
                    <th class="text-left py-4 px-6 font-semibold text-sm">Disponibilidade</th>
                    <th class="text-right py-4 px-6 font-semibold text-sm">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($books as $book)
                <tr class="hover:bg-gray-50">
                    <td class="py-4 px-6">{{ $book->id }}</td>
                    <td class="py-4 px-6 font-semibold">{{ Str::limit($book->title, 40) }}</td>
                    <td class="py-4 px-6 text-gray-600 text-sm">{{ $book->authors->pluck('name')->join(', ') }}</td>
                    <td class="py-4 px-6">
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">
                            {{ $book->category->name }}
                        </span>
                    </td>
                    <td class="py-4 px-6 text-gray-600 text-sm">{{ $book->isbn }}</td>
                    <td class="py-4 px-6">
                        @if($book->isAvailable())
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $book->available_quantity }}/{{ $book->quantity }}
                            </span>
                        @else
                            <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-semibold">
                                Indisponível
                            </span>
                        @endif
                    </td>
                    <td class="py-4 px-6 text-right">
                        <a href="{{ route('admin.books.show', $book) }}" class="text-blue-600 hover:text-blue-800 mr-3">
                            Ver
                        </a>
                        <a href="{{ route('admin.books.edit', $book) }}" class="text-green-600 hover:text-green-800 mr-3">
                            Editar
                        </a>
                        <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-12 text-gray-500">
                        <div class="text-6xl mb-4">📚</div>
                        Nenhum livro encontrado
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $books->links() }}
    </div>
</div>
@endsection