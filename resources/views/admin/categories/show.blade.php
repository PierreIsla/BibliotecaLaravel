@extends('layouts.app')

@section('title', $category->name . ' - Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <div class="mb-6">
        <a href="{{ route('admin.categories.index') }}" class="text-blue-600 hover:underline">
            ← Voltar para categorias
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-4xl font-bold mb-2">{{ $category->name }}</h1>
                <p class="text-gray-600">{{ $category->description }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.categories.edit', $category) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Editar
                </a>
                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Tem certeza?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                        Eliminar
                    </button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4 p-4 bg-gray-50 rounded-lg">
            <div>
                <p class="text-gray-600 text-sm">Slug</p>
                <p class="font-semibold">{{ $category->slug }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Total de Livros</p>
                <p class="font-semibold">{{ $category->books->count() }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Criada em</p>
                <p class="font-semibold">{{ $category->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>

    <!-- Books in this Category -->
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold mb-6">Livros nesta Categoria ({{ $category->books->count() }})</h2>
        
        @if($category->books->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                @foreach($category->books as $book)
                    <div class="border rounded-lg p-4 hover:shadow-lg transition">
                        <h3 class="font-bold mb-2">{{ $book->title }}</h3>
                        <p class="text-sm text-gray-600 mb-2">{{ $book->authors->pluck('name')->join(', ') }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-xs {{ $book->isAvailable() ? 'text-green-600' : 'text-red-600' }}">
                                {{ $book->isAvailable() ? 'Disponível' : 'Indisponível' }}
                            </span>
                            <a href="{{ route('admin.books.show', $book) }}" class="text-blue-600 hover:underline text-sm">
                                Ver →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12 text-gray-500">
                <div class="text-6xl mb-4">📚</div>
                <p>Nenhum livro nesta categoria ainda</p>
            </div>
        @endif
    </div>
</div>
@endsection