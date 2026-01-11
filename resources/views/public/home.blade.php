@extends('layouts.app')

@section('title', 'Início - Biblioteca')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-lg p-12 mb-8 shadow-xl">
        <h1 class="text-5xl font-bold mb-4">Bem-vindo à Nossa Biblioteca</h1>
        <p class="text-xl mb-6">Descubra milhares de livros e comece a sua jornada literária</p>
        <a href="{{ route('books') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 inline-block">
            Explorar Livros →
        </a>
    </div>

    <!-- Search Bar -->
    <div class="mb-8">
        <form action="{{ route('search') }}" method="GET" class="flex gap-2">
            <input 
                type="text" 
                name="q" 
                placeholder="Pesquisar livros, autores, ISBN..." 
                class="flex-1 px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                value="{{ request('q') }}"
            >
            <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 font-semibold">
                🔍 Pesquisar
            </button>
        </form>
    </div>

    <!-- Categories -->
    <div class="mb-12">
        <h2 class="text-3xl font-bold mb-6">Explorar por Categoria</h2>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            @foreach($categories as $category)
                <a href="{{ route('books', ['category' => $category->id]) }}" 
                   class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition text-center group">
                    <div class="text-4xl mb-2">📚</div>
                    <h3 class="font-semibold text-lg group-hover:text-blue-600">{{ $category->name }}</h3>
                    <p class="text-sm text-gray-600 mt-1">{{ $category->books_count }} livros</p>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Featured Books -->
    <div>
        <h2 class="text-3xl font-bold mb-6">Livros em Destaque</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @foreach($featured_books as $book)
                <div class="bg-white rounded-lg shadow hover:shadow-xl transition overflow-hidden">
                    @if($book->cover_image)
                        <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="w-full h-64 object-cover">
                    @else
                        <div class="w-full h-64 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                            <span class="text-white text-6xl">📖</span>
                        </div>
                    @endif
                    
                    <div class="p-4">
                        <h3 class="font-bold text-lg mb-2 line-clamp-2">{{ $book->title }}</h3>
                        <p class="text-sm text-gray-600 mb-2">
                            {{ $book->authors->pluck('name')->join(', ') }}
                        </p>
                        <p class="text-sm text-gray-500 mb-3">
                            <span class="bg-gray-100 px-2 py-1 rounded">{{ $book->category->name }}</span>
                        </p>
                        
                        @if($book->isAvailable())
                            <span class="inline-block bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full">
                                ✓ Disponível ({{ $book->available_quantity }})
                            </span>
                        @else
                            <span class="inline-block bg-red-100 text-red-800 text-xs px-3 py-1 rounded-full">
                                ✗ Indisponível
                            </span>
                        @endif
                        
                        <a href="{{ route('book.show', $book) }}" class="block mt-3 text-blue-600 hover:text-blue-800 font-semibold">
                            Ver detalhes →
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection