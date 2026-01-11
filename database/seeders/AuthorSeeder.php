<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        $authors = [
            [
                'name' => 'José Saramago',
                'biography' => 'Escritor português, Nobel de Literatura em 1998.',
                'birth_date' => '1922-11-16',
                'nationality' => 'Portuguesa',
            ],
            [
                'name' => 'Fernando Pessoa',
                'biography' => 'Um dos maiores poetas da língua portuguesa.',
                'birth_date' => '1888-06-13',
                'nationality' => 'Portuguesa',
            ],
            [
                'name' => 'J.K. Rowling',
                'biography' => 'Autora britânica, criadora de Harry Potter.',
                'birth_date' => '1965-07-31',
                'nationality' => 'Britânica',
            ],
            [
                'name' => 'George Orwell',
                'biography' => 'Escritor e jornalista britânico.',
                'birth_date' => '1903-06-25',
                'nationality' => 'Britânica',
            ],
            [
                'name' => 'Machado de Assis',
                'biography' => 'Maior nome da literatura brasileira.',
                'birth_date' => '1839-06-21',
                'nationality' => 'Brasileira',
            ],
            [
                'name' => 'Agatha Christie',
                'biography' => 'Rainha do crime, autora de mistérios.',
                'birth_date' => '1890-09-15',
                'nationality' => 'Britânica',
            ],
            [
                'name' => 'Stephen King',
                'biography' => 'Mestre do terror e suspense.',
                'birth_date' => '1947-09-21',
                'nationality' => 'Americana',
            ],
            [
                'name' => 'Isaac Asimov',
                'biography' => 'Um dos grandes nomes da ficção científica.',
                'birth_date' => '1920-01-02',
                'nationality' => 'Americana',
            ],
            [
                'name' => 'Clarice Lispector',
                'biography' => 'Escritora e jornalista brasileira.',
                'birth_date' => '1920-12-10',
                'nationality' => 'Brasileira',
            ],
            [
                'name' => 'Gabriel García Márquez',
                'biography' => 'Escritor colombiano, Nobel de Literatura.',
                'birth_date' => '1927-03-06',
                'nationality' => 'Colombiana',
            ],
        ];

        foreach ($authors as $author) {
            Author::create($author);
        }
    }
}