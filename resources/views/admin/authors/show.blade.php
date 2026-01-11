@extends('layouts.app')

@section('title', $author->name . ' - Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <div class="mb-6">
        <a href="{{ route('admin.authors.index') }}" class="text-blue-600 hover:underline">
            ← Voltar para autores
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 p-8">
            <!-- Photo -->
            <div>
                @if($author->photo)
                    <img src="{{ asset('storage/' . $author->photo) }}" alt="{{ $author->name }}" class="w-full rounded-lg shadow-lg">
                @else
                    <div class="w-full h-64 bg-gradient-to-br from-green-400 to-green-600 rounded-lg flex items-center justify-center">
                        <span class="text-white text-8xl">✍️</span>
                    </div>
                @endif
            </div>

            <!-- Info -->
            <div class="md:col-span-2">
                <div class="flex justify-between items-start mb-6">
                    <h1 class="text-4xl font-bold">{{ $author->name }}</h1>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.authors.edit', $author) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            Editar
                        </a>
                        <form action="{{ route('admin.authors.destroy', $author) }}" method="POST" onsubmit="return confirm('Tem certeza?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6 p-4 bg-gray-50 rounded-lg">
                    <div>
                        <p class="text-gray-600 text-sm">Nacionalidade</p>
                        <p class="font-semibold">{{ $author->nationality ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Data de Nascimento</p>
                        <p class="font-semibold">{{ $author->birth_date ? $author->birth_date->format('d/m/Y') : '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Idade</p>
                        <p class="font-semibold">{{ $author->age ?? '-' }} anos</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Total de Livros</p>
                        <p class="font-semibold">{{ $author->books->count() }}</p>
                    </div>
                </div>

                @if($author->biography)
                    <div class="mb-6">
                        <h3 class="text-xl font-bold mb-3">Biografia</h3>
                        <p class="text-gray-700 leading-relaxed">{{ $author->biography }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Books by this Author -->
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold mb-6">Livros deste Autor ({{ $author->books->count() }})</h2>
        
        @if($author->books->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                @foreach($author->books as $book)
                    <div class="border rounded-lg p-4 hover:shadow-lg transition">
                        <h3 class="font-bold mb-2 line-clamp-2">{{ $book->title }}</h3>
                        <p class="text-sm text-gray-600 mb-2">{{ $book->category->name }}</p>
                        <p class="text-sm text-gray-500 mb-2">{{ $book->publication_year }}</p>
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
                <p>Nenhum livro deste autor ainda</p>
            </div>
        @endif
    </div>
</div>
@endsection