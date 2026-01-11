<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use App\Models\Author;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();
        $authors = Author::all();

        $books = [
            [
                'title' => 'Ensaio sobre a Cegueira',
                'isbn' => '9789722011891',
                'description' => 'Um romance sobre uma epidemia de cegueira branca que assola uma cidade inteira.',
                'publication_year' => 1995,
                'pages' => 310,
                'publisher' => 'Caminho',
                'language' => 'pt',
                'quantity' => 5,
                'available_quantity' => 3,
                'category' => 'Ficção',
                'authors' => ['José Saramago'],
                'cover_url' => 'https://covers.openlibrary.org/b/isbn/9789722011891-L.jpg'
            ],
            [
                'title' => 'Harry Potter e a Pedra Filosofal',
                'isbn' => '9789722325721',
                'description' => 'O primeiro livro da saga de Harry Potter, onde ele descobre ser um bruxo.',
                'publication_year' => 1997,
                'pages' => 254,
                'publisher' => 'Presença',
                'language' => 'pt',
                'quantity' => 8,
                'available_quantity' => 6,
                'category' => 'Fantasia',
                'authors' => ['J.K. Rowling'],
                'cover_url' => 'https://covers.openlibrary.org/b/isbn/9780439708180-L.jpg'
            ],
            [
                'title' => 'O Código Da Vinci',
                'isbn' => '9789722520447',
                'description' => 'Um thriller que mistura arte, história e conspiração.',
                'publication_year' => 2003,
                'pages' => 489,
                'publisher' => 'Bertrand',
                'language' => 'pt',
                'quantity' => 6,
                'available_quantity' => 4,
                'category' => 'Suspense',
                'authors' => ['Dan Brown'],
                'cover_url' => 'https://covers.openlibrary.org/b/isbn/9780307474278-L.jpg'
            ],
            [
                'title' => '1984',
                'isbn' => '9789722051057',
                'description' => 'Uma distopia sobre um regime totalitário que controla todos os aspectos da vida.',
                'publication_year' => 1949,
                'pages' => 328,
                'publisher' => 'Antígona',
                'language' => 'pt',
                'quantity' => 7,
                'available_quantity' => 5,
                'category' => 'Ficção Científica',
                'authors' => ['George Orwell'],
                'cover_url' => 'https://covers.openlibrary.org/b/isbn/9780451524935-L.jpg'
            ],
            [
                'title' => 'O Hobbit',
                'isbn' => '9789722034142',
                'description' => 'A aventura de Bilbo Bolseiro na Terra Média.',
                'publication_year' => 1937,
                'pages' => 310,
                'publisher' => 'Europa-América',
                'language' => 'pt',
                'quantity' => 6,
                'available_quantity' => 4,
                'category' => 'Fantasia',
                'authors' => ['J.R.R. Tolkien'],
                'cover_url' => 'https://covers.openlibrary.org/b/isbn/9780547928227-L.jpg'
            ],
            [
                'title' => 'O Senhor dos Anéis: A Sociedade do Anel',
                'isbn' => '9789722034319',
                'description' => 'O início da épica jornada para destruir o Um Anel.',
                'publication_year' => 1954,
                'pages' => 423,
                'publisher' => 'Europa-América',
                'language' => 'pt',
                'quantity' => 5,
                'available_quantity' => 3,
                'category' => 'Fantasia',
                'authors' => ['J.R.R. Tolkien'],
                'cover_url' => 'https://covers.openlibrary.org/b/isbn/9780547928210-L.jpg'
            ],
            [
                'title' => 'O Alquimista',
                'isbn' => '9789722515771',
                'description' => 'A história de Santiago, um pastor andaluz que busca seu tesouro.',
                'publication_year' => 1988,
                'pages' => 188,
                'publisher' => 'Pergaminho',
                'language' => 'pt',
                'quantity' => 10,
                'available_quantity' => 8,
                'category' => 'Romance',
                'authors' => ['Paulo Coelho'],
                'cover_url' => 'https://covers.openlibrary.org/b/isbn/9780062315007-L.jpg'
            ],
            [
                'title' => 'Cem Anos de Solidão',
                'isbn' => '9789722018234',
                'description' => 'A saga da família Buendía em Macondo.',
                'publication_year' => 1967,
                'pages' => 471,
                'publisher' => 'Dom Quixote',
                'language' => 'pt',
                'quantity' => 4,
                'available_quantity' => 2,
                'category' => 'Romance',
                'authors' => ['Gabriel García Márquez'],
                'cover_url' => 'https://covers.openlibrary.org/b/isbn/9780060883287-L.jpg'
            ],
            [
                'title' => 'Sapiens: História Breve da Humanidade',
                'isbn' => '9789896442668',
                'description' => 'Uma exploração da história da humanidade desde a Idade da Pedra até a era moderna.',
                'publication_year' => 2011,
                'pages' => 443,
                'publisher' => 'Elsinore',
                'language' => 'pt',
                'quantity' => 8,
                'available_quantity' => 6,
                'category' => 'História',
                'authors' => ['Yuval Noah Harari'],
                'cover_url' => 'https://covers.openlibrary.org/b/isbn/9780062316097-L.jpg'
            ],
            [
                'title' => 'A Menina que Roubava Livros',
                'isbn' => '9789722528474',
                'description' => 'A história de Liesel, uma menina que rouba livros durante a Segunda Guerra Mundial.',
                'publication_year' => 2005,
                'pages' => 480,
                'publisher' => 'Presença',
                'language' => 'pt',
                'quantity' => 7,
                'available_quantity' => 5,
                'category' => 'Romance',
                'authors' => ['Markus Zusak'],
                'cover_url' => 'https://covers.openlibrary.org/b/isbn/9780375842207-L.jpg'
            ],
            [
                'title' => 'A Origem das Espécies',
                'isbn' => '9789722528948',
                'description' => 'A obra revolucionária de Darwin sobre a evolução das espécies.',
                'publication_year' => 1859,
                'pages' => 502,
                'publisher' => 'Planeta Vivo',
                'language' => 'pt',
                'quantity' => 3,
                'available_quantity' => 2,
                'category' => 'Ciência',
                'authors' => ['Charles Darwin'],
                'cover_url' => 'https://covers.openlibrary.org/b/isbn/9780451529060-L.jpg'
            ],
            [
                'title' => 'Orgulho e Preconceito',
                'isbn' => '9789722528955',
                'description' => 'Um clássico romance sobre Elizabeth Bennet e Mr. Darcy.',
                'publication_year' => 1813,
                'pages' => 424,
                'publisher' => 'Penguin Clássicos',
                'language' => 'pt',
                'quantity' => 6,
                'available_quantity' => 4,
                'category' => 'Romance',
                'authors' => ['Jane Austen'],
                'cover_url' => 'https://covers.openlibrary.org/b/isbn/9780141439518-L.jpg'
            ],
        ];

        foreach ($books as $bookData) {
            $category = $categories->where('name', $bookData['category'])->first();
            
            if (!$category) {
                continue;
            }

            // Baixar a capa do livro
            $coverPath = null;
            if (isset($bookData['cover_url'])) {
                try {
                    $response = Http::timeout(10)->get($bookData['cover_url']);
                    
                    if ($response->successful() && $response->body()) {
                        $fileName = 'covers/' . uniqid() . '.jpg';
                        Storage::disk('public')->put('books/' . $fileName, $response->body());
                        $coverPath = 'books/' . $fileName;
                    }
                } catch (\Exception $e) {
                    // Se falhar, não tem problema, vai usar o placeholder
                }
            }

            $book = Book::create([
                'title' => $bookData['title'],
                'isbn' => $bookData['isbn'],
                'description' => $bookData['description'],
                'publication_year' => $bookData['publication_year'],
                'pages' => $bookData['pages'],
                'publisher' => $bookData['publisher'],
                'language' => $bookData['language'],
                'quantity' => $bookData['quantity'],
                'available_quantity' => $bookData['available_quantity'],
                'category_id' => $category->id,
                'cover_image' => $coverPath,
            ]);

            // Associar autores
            foreach ($bookData['authors'] as $authorName) {
                $author = $authors->where('name', $authorName)->first();
                if ($author) {
                    $book->authors()->attach($author->id);
                }
            }
        }
    }
}