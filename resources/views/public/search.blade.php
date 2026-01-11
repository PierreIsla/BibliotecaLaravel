@extends('layouts.app')

@section('title', 'Pesquisa - Biblioteca')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <h1 class="text-4xl font-bold mb-4">Resultados da Pesquisa</h1>
    <p class="text-gray-600 mb-8">Pesquisa por: <strong>"{{ $search }}"</strong> - {{ $books->total() }} resultados</p>

    <!-- Books Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
        @forelse($books as $book)
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
                        <span class="bg-gray-100 px-2 py-1 rounded text-xs">{{ $book->category->name }}</span>
                    </p>
                    
                    @if($book->isAvailable())
                        <span class="inline-block bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full mb-2">
                            ✓ Disponível
                        </span>
                    @else
                        <span class="inline-block bg-red-100 text-red-800 text-xs px-3 py-1 rounded-full mb-2">
                            ✗ Indisponível
                        </span>
                    @endif
                    
                    <a href="{{ route('book.show', $book) }}" class="block mt-3 text-blue-600 hover:text-blue-800 font-semibold">
                        Ver detalhes →
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <div class="text-6xl mb-4">🔍</div>
                <p class="text-gray-600 text-lg">Nenhum livro encontrado para "{{ $search }}"</p>
                <a href="{{ route('books') }}" class="inline-block mt-4 text-blue-600 hover:underline">
                    Ver todos os livros
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $books->appends(['q' => $search])->links() }}
    </div>
</div>
@endsection