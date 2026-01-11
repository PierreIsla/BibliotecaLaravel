@extends('layouts.app')

@section('title', $book->title . ' - Biblioteca')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <!-- Breadcrumb -->
    <nav class="mb-6 text-sm">
        <a href="{{ route('home') }}" class="text-blue-600 hover:underline">Início</a>
        <span class="mx-2">/</span>
        <a href="{{ route('books') }}" class="text-blue-600 hover:underline">Livros</a>
        <span class="mx-2">/</span>
        <span class="text-gray-600">{{ $book->title }}</span>
    </nav>

    <!-- Book Details -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 p-8">
            <!-- Cover Image -->
            <div>
                @if($book->cover_image)
                    <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="w-full rounded-lg shadow-lg">
                @else
                    <div class="w-full h-96 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center">
                        <span class="text-white text-8xl">📖</span>
                    </div>
                @endif

                <!-- Availability -->
                <div class="mt-6">
                    @if($book->isAvailable())
                        <div class="bg-green-100 text-green-800 px-4 py-3 rounded-lg text-center">
                            <div class="font-bold text-lg">✓ Disponível</div>
                            <div class="text-sm">{{ $book->available_quantity }} de {{ $book->quantity }} exemplares</div>
                        </div>
                    @else
                        <div class="bg-red-100 text-red-800 px-4 py-3 rounded-lg text-center">
                            <div class="font-bold text-lg">✗ Indisponível</div>
                            <div class="text-sm">Todos os exemplares emprestados</div>
                        </div>
                    @endif
                </div>

                @if($book->pdf_file)
                    <a href="{{ $book->pdf_url }}" target="_blank" class="block mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg text-center hover:bg-blue-700">
                        📄 Ver PDF
                    </a>
                @endif
            </div>

            <!-- Book Info -->
            <div class="md:col-span-2">
                <h1 class="text-4xl font-bold mb-4">{{ $book->title }}</h1>
                
                <div class="mb-6">
                    <h2 class="text-xl text-gray-700 mb-2">
                        Por 
                        @foreach($book->authors as $author)
                            <span class="text-blue-600">{{ $author->name }}</span>{{ !$loop->last ? ', ' : '' }}
                        @endforeach
                    </h2>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <span class="text-gray-600 font-semibold">Categoria:</span>
                        <span class="ml-2 bg-blue-100 text-blue-800 px-3 py-1 rounded text-sm">{{ $book->category->name }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600 font-semibold">ISBN:</span>
                        <span class="ml-2">{{ $book->isbn }}</span>
                    </div>
                    @if($book->publication_year)
                        <div>
                            <span class="text-gray-600 font-semibold">Ano:</span>
                            <span class="ml-2">{{ $book->publication_year }}</span>
                        </div>
                    @endif
                    @if($book->pages)
                        <div>
                            <span class="text-gray-600 font-semibold">Páginas:</span>
                            <span class="ml-2">{{ $book->pages }}</span>
                        </div>
                    @endif
                    @if($book->publisher)
                        <div>
                            <span class="text-gray-600 font-semibold">Editora:</span>
                            <span class="ml-2">{{ $book->publisher }}</span>
                        </div>
                    @endif
                    <div>
                        <span class="text-gray-600 font-semibold">Idioma:</span>
                        <span class="ml-2">{{ strtoupper($book->language) }}</span>
                    </div>
                </div>

                @if($book->description)
                    <div class="mb-6">
                        <h3 class="text-xl font-bold mb-3">Sobre o livro</h3>
                        <p class="text-gray-700 leading-relaxed">{{ $book->description }}</p>
                    </div>
                @endif

                <!-- Authors Bio -->
                @if($book->authors->count() > 0)
                    <div class="mt-8">
                        <h3 class="text-xl font-bold mb-4">Sobre {{ $book->authors->count() > 1 ? 'os autores' : 'o autor' }}</h3>
                        @foreach($book->authors as $author)
                            <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                                <h4 class="font-bold text-lg mb-2">{{ $author->name }}</h4>
                                @if($author->biography)
                                    <p class="text-gray-600 text-sm">{{ Str::limit($author->biography, 200) }}</p>
                                @endif
                                @if($author->nationality)
                                    <p class="text-sm text-gray-500 mt-2">Nacionalidade: {{ $author->nationality }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Related Books -->
    @if($related_books->count() > 0)
        <div>
            <h2 class="text-2xl font-bold mb-6">Livros Relacionados</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                @foreach($related_books as $related)
                    <div class="bg-white rounded-lg shadow hover:shadow-xl transition overflow-hidden">
                        @if($related->cover_image)
                            <img src="{{ $related->cover_url }}" alt="{{ $related->title }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                                <span class="text-white text-5xl">📖</span>
                            </div>
                        @endif
                        
                        <div class="p-4">
                            <h3 class="font-bold text-lg mb-2 line-clamp-2">{{ $related->title }}</h3>
                            <p class="text-sm text-gray-600 mb-3">
                                {{ $related->authors->pluck('name')->join(', ') }}
                            </p>
                            <a href="{{ route('book.show', $related) }}" class="text-blue-600 hover:text-blue-800 font-semibold text-sm">
                                Ver detalhes →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection