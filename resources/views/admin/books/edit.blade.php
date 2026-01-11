@extends('layouts.app')

@section('title', 'Editar Livro - Admin')

@section('content')
<div class="max-w-4xl mx-auto px-4">
    <div class="mb-6">
        <a href="{{ route('admin.books.index') }}" class="text-blue-600 hover:underline">
            ← Voltar para livros
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold mb-6">Editar Livro: {{ $book->title }}</h1>

        <form action="{{ route('admin.books.update', $book) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-6 mb-6">
                <div class="col-span-2">
                    <label for="title" class="block text-sm font-semibold mb-2">Título do Livro *</label>
                    <input 
                        type="text" 
                        name="title" 
                        id="title" 
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror"
                        value="{{ old('title', $book->title) }}"
                        required
                    >
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="isbn" class="block text-sm font-semibold mb-2">ISBN *</label>
                    <input 
                        type="text" 
                        name="isbn" 
                        id="isbn" 
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('isbn') border-red-500 @enderror"
                        value="{{ old('isbn', $book->isbn) }}"
                        required
                    >
                    @error('isbn')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="category_id" class="block text-sm font-semibold mb-2">Categoria *</label>
                    <select 
                        name="category_id" 
                        id="category_id" 
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('category_id') border-red-500 @enderror"
                        required
                    >
                        <option value="">Selecione...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="author_ids" class="block text-sm font-semibold mb-2">Autores * (pressione Ctrl para selecionar múltiplos)</label>
                <select 
                    name="author_ids[]" 
                    id="author_ids" 
                    multiple
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('author_ids') border-red-500 @enderror"
                    size="5"
                    required
                >
                    @foreach($authors as $author)
                        <option value="{{ $author->id }}" 
                            {{ in_array($author->id, old('author_ids', $book->authors->pluck('id')->toArray())) ? 'selected' : '' }}>
                            {{ $author->name }}
                        </option>
                    @endforeach
                </select>
                @error('author_ids')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="description" class="block text-sm font-semibold mb-2">Descrição</label>
                <textarea 
                    name="description" 
                    id="description" 
                    rows="4"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                >{{ old('description', $book->description) }}</textarea>
            </div>

            <div class="grid grid-cols-3 gap-6 mb-6">
                <div>
                    <label for="publication_year" class="block text-sm font-semibold mb-2">Ano de Publicação</label>
                    <input 
                        type="number" 
                        name="publication_year" 
                        id="publication_year" 
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                        value="{{ old('publication_year', $book->publication_year) }}"
                        min="1000"
                        max="{{ date('Y') }}"
                    >
                </div>

                <div>
                    <label for="pages" class="block text-sm font-semibold mb-2">Páginas</label>
                    <input 
                        type="number" 
                        name="pages" 
                        id="pages" 
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                        value="{{ old('pages', $book->pages) }}"
                        min="1"
                    >
                </div>

                <div>
                    <label for="language" class="block text-sm font-semibold mb-2">Idioma *</label>
                    <select 
                        name="language" 
                        id="language" 
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                        required
                    >
                        <option value="pt" {{ old('language', $book->language) == 'pt' ? 'selected' : '' }}>Português</option>
                        <option value="en" {{ old('language', $book->language) == 'en' ? 'selected' : '' }}>Inglês</option>
                        <option value="es" {{ old('language', $book->language) == 'es' ? 'selected' : '' }}>Espanhol</option>
                        <option value="fr" {{ old('language', $book->language) == 'fr' ? 'selected' : '' }}>Francês</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-6 mb-6">
                <div>
                    <label for="publisher" class="block text-sm font-semibold mb-2">Editora</label>
                    <input 
                        type="text" 
                        name="publisher" 
                        id="publisher" 
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                        value="{{ old('publisher', $book->publisher) }}"
                    >
                </div>

                <div>
                    <label for="quantity" class="block text-sm font-semibold mb-2">Quantidade Total *</label>
                    <input 
                        type="number" 
                        name="quantity" 
                        id="quantity" 
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                        value="{{ old('quantity', $book->quantity) }}"
                        min="1"
                        required
                    >
                </div>

                <div>
                    <label for="available_quantity" class="block text-sm font-semibold mb-2">Quantidade Disponível *</label>
                    <input 
                        type="number" 
                        name="available_quantity" 
                        id="available_quantity" 
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                        value="{{ old('available_quantity', $book->available_quantity) }}"
                        min="0"
                        required
                    >
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="cover_image" class="block text-sm font-semibold mb-2">Capa do Livro</label>
                    
                    @if($book->cover_image)
                        <div class="mb-4">
                            <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="w-32 h-48 object-cover rounded-lg shadow">
                            <p class="text-sm text-gray-500 mt-2">Capa atual</p>
                        </div>
                    @endif
                    
                    <input 
                        type="file" 
                        name="cover_image" 
                        id="cover_image" 
                        accept="image/*"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                    >
                    <p class="text-sm text-gray-500 mt-1">Deixe em branco para manter a capa atual</p>
                </div>

                <div>
                    <label for="pdf_file" class="block text-sm font-semibold mb-2">Arquivo PDF</label>
                    
                    @if($book->pdf_file)
                        <div class="mb-4">
                            <a href="{{ $book->pdf_url }}" target="_blank" class="text-blue-600 hover:underline">
                                📄 Ver PDF atual
                            </a>
                        </div>
                    @endif
                    
                    <input 
                        type="file" 
                        name="pdf_file" 
                        id="pdf_file" 
                        accept=".pdf"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                    >
                    <p class="text-sm text-gray-500 mt-1">Deixe em branco para manter o PDF atual</p>
                </div>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 font-semibold">
                    Atualizar Livro
                </button>
                <a href="{{ route('admin.books.index') }}" class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-400 font-semibold">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
