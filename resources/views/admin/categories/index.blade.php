@extends('layouts.app')

@section('title', 'Categorias - Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold">Gestão de Categorias</h1>
        <a href="{{ route('admin.categories.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 font-semibold shadow-lg">
            ➕ Nova Categoria
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b-2 border-gray-200">
                <tr>
                    <th class="text-left py-4 px-6 font-semibold text-sm">ID</th>
                    <th class="text-left py-4 px-6 font-semibold text-sm">Nome</th>
                    <th class="text-left py-4 px-6 font-semibold text-sm">Slug</th>
                    <th class="text-left py-4 px-6 font-semibold text-sm">Nº Livros</th>
                    <th class="text-left py-4 px-6 font-semibold text-sm">Criada em</th>
                    <th class="text-right py-4 px-6 font-semibold text-sm">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($categories as $category)
                <tr class="hover:bg-gray-50">
                    <td class="py-4 px-6">{{ $category->id }}</td>
                    <td class="py-4 px-6 font-semibold">{{ $category->name }}</td>
                    <td class="py-4 px-6 text-gray-600">{{ $category->slug }}</td>
                    <td class="py-4 px-6">
                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                            {{ $category->books_count }}
                        </span>
                    </td>
                    <td class="py-4 px-6 text-gray-600">{{ $category->created_at->format('d/m/Y') }}</td>
                    <td class="py-4 px-6 text-right">
                        <a href="{{ route('admin.categories.show', $category) }}" class="text-blue-600 hover:text-blue-800 mr-3">
                            Ver
                        </a>
                        <a href="{{ route('admin.categories.edit', $category) }}" class="text-green-600 hover:text-green-800 mr-3">
                            Editar
                        </a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza?')">
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
                    <td colspan="6" class="text-center py-12 text-gray-500">
                        <div class="text-6xl mb-4">📂</div>
                        Nenhuma categoria encontrada
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $categories->links() }}
    </div>
</div>
@endsection