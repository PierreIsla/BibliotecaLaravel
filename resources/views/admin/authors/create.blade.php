@extends('layouts.app')

@section('title', 'Novo Autor - Admin')

@section('content')
<div class="max-w-3xl mx-auto px-4">
    <div class="mb-6">
        <a href="{{ route('admin.authors.index') }}" class="text-blue-600 hover:underline">
            ← Voltar para autores
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold mb-6">Novo Autor</h1>

        <form action="{{ route('admin.authors.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-6">
                <label for="name" class="block text-sm font-semibold mb-2">Nome do Autor *</label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                    value="{{ old('name') }}"
                    required
                >
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="nationality" class="block text-sm font-semibold mb-2">Nacionalidade</label>
                    <input 
                        type="text" 
                        name="nationality" 
                        id="nationality" 
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                        value="{{ old('nationality') }}"
                    >
                </div>

                <div>
                    <label for="birth_date" class="block text-sm font-semibold mb-2">Data de Nascimento</label>
                    <input 
                        type="date" 
                        name="birth_date" 
                        id="birth_date" 
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                        value="{{ old('birth_date') }}"
                    >
                </div>
            </div>

            <div class="mb-6">
                <label for="biography" class="block text-sm font-semibold mb-2">Biografia</label>
                <textarea 
                    name="biography" 
                    id="biography" 
                    rows="6"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                >{{ old('biography') }}</textarea>
            </div>

            <div class="mb-6">
                <label for="photo" class="block text-sm font-semibold mb-2">Foto do Autor</label>
                <input 
                    type="file" 
                    name="photo" 
                    id="photo" 
                    accept="image/*"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                >
                <p class="text-sm text-gray-500 mt-1">Formatos aceites: JPG, PNG, GIF (máx. 2MB)</p>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 font-semibold">
                    Criar Autor
                </button>
                <a href="{{ route('admin.authors.index') }}" class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-400 font-semibold">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection