<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Ficção Científica', 'description' => 'Livros de ficção científica e futurismo'],
            ['name' => 'Romance', 'description' => 'Obras românticas e sentimentais'],
            ['name' => 'Suspense', 'description' => 'Thrillers e livros de suspense'],
            ['name' => 'Fantasia', 'description' => 'Mundos mágicos e criaturas fantásticas'],
            ['name' => 'História', 'description' => 'Livros históricos e biografias'],
            ['name' => 'Tecnologia', 'description' => 'Livros técnicos e de programação'],
            ['name' => 'Filosofia', 'description' => 'Obras filosóficas e reflexivas'],
            ['name' => 'Autoajuda', 'description' => 'Desenvolvimento pessoal e profissional'],
            ['name' => 'Poesia', 'description' => 'Coleções de poesia e verso'],
            ['name' => 'Infantil', 'description' => 'Literatura infantil e juvenil'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}