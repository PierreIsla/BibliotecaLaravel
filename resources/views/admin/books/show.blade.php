@extends('layouts.app')

@section('title', $book->title . ' - Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <div class="mb-6">
        <a href="{{ route('admin.books.index') }}" class="text-blue-600 hover:underline">
            ← Voltar para livros
        </a>
    </div>

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

                <!-- Actions -->
                <div class="mt-6 space-y-2">
                    <a href="{{ route('admin.books.edit', $book) }}" class="block w-full bg-blue-600 text-white px-4 py-3 rounded-lg hover:bg-blue-700 text-center font-semibold">
                        Editar Livro
                    </a>
                    
                    @if($book->pdf_file)
                        <a href="{{ $book->pdf_url }}" target="_blank" class="block w-full bg-green-600 text-white px-4 py-3 rounded-lg hover:bg-green-700 text-center font-semibold">
                            📄 Ver PDF
                        </a>
                    @endif
                    
                    <form action="{{ route('admin.books.destroy', $book) }}" method="POST" onsubmit="return confirm('Tem certeza?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-600 text-white px-4 py-3 rounded-lg hover:bg-red-700 font-semibold">
                            Eliminar Livro
                        </button>
                    </form>
                </div>

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
            </div>

            <!-- Book Info -->
            <div class="md:col-span-2">
                <h1 class="text-4xl font-bold mb-4">{{ $book->title }}</h1>
                
                <div class="mb-6">
                    <h2 class="text-xl text-gray-700 mb-2">
                        Por 
                        @foreach($book->authors as $author)
                            <a href="{{ route('admin.authors.show', $author) }}" class="text-blue-600 hover:underline">
                                {{ $author->name }}
                            </a>{{ !$loop->last ? ', ' : '' }}
                        @endforeach
                    </h2>
                </div>

                <!-- Details Grid -->
                <div class="grid grid-cols-2 gap-4 mb-6 p-4 bg-gray-50 rounded-lg">
                    <div>
                        <span class="text-gray-600 font-semibold">Categoria:</span>
                        <a href="{{ route('admin.categories.show', $book->category) }}" class="ml-2 text-blue-600 hover:underline">
                            {{ $book->category->name }}
                        </a>
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
                    <div>
                        <span class="text-gray-600 font-semibold">Criado em:</span>
                        <span class="ml-2">{{ $book->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600 font-semibold">Atualizado em:</span>
                        <span class="ml-2">{{ $book->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>

                @if($book->description)
                    <div class="mb-6">
                        <h3 class="text-xl font-bold mb-3">Sobre o livro</h3>
                        <p class="text-gray-700 leading-relaxed">{{ $book->description }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Loans History -->
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold mb-6">Histórico de Empréstimos ({{ $book->loans->count() }})</h2>
        
        @if($book->loans->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b-2 border-gray-200">
                        <tr>
                            <th class="text-left py-3 px-4 font-semibold text-sm">Utilizador</th>
                            <th class="text-left py-3 px-4 font-semibold text-sm">Data Empréstimo</th>
                            <th class="text-left py-3 px-4 font-semibold text-sm">Data Devolução</th>
                            <th class="text-left py-3 px-4 font-semibold text-sm">Devolvido em</th>
                            <th class="text-left py-3 px-4 font-semibold text-sm">Status</th>
                            <th class="text-left py-3 px-4 font-semibold text-sm">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($book->loans as $loan)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4">{{ $loan->user->name }}</td>
                            <td class="py-3 px-4">{{ $loan->loan_date->format('d/m/Y') }}</td>
                            <td class="py-3 px-4">{{ $loan->due_date->format('d/m/Y') }}</td>
                            <td class="py-3 px-4">{{ $loan->return_date ? $loan->return_date->format('d/m/Y') : '-' }}</td>
                            <td class="py-3 px-4">
                                @if($loan->status === 'active')
                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">Ativo</span>
                                @elseif($loan->status === 'overdue')
                                    <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-semibold">Atrasado</span>
                                @else
                                    <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs font-semibold">Devolvido</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <a href="{{ route('admin.loans.show', $loan) }}" class="text-blue-600 hover:underline">
                                    Ver detalhes
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12 text-gray-500">
                <div class="text-6xl mb-4">📋</div>
                <p>Nenhum empréstimo registado para este livro</p>
            </div>
        @endif
    </div>
</div>
@endsection