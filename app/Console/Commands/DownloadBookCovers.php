<?php

namespace App\Console\Commands;

use App\Models\Book;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DownloadBookCovers extends Command
{
    protected $signature = 'books:download-covers';
    protected $description = 'Download book covers from Open Library API';

    public function handle()
    {
        $this->info('Downloading book covers...');
        
        $books = Book::whereNull('cover_image')->get();
        
        $coverUrls = [
            '9789722011891' => 'https://covers.openlibrary.org/b/isbn/9789722011891-L.jpg',
            '9789722325721' => 'https://covers.openlibrary.org/b/isbn/9780439708180-L.jpg',
            '9789722520447' => 'https://covers.openlibrary.org/b/isbn/9780307474278-L.jpg',
            '9789722051057' => 'https://covers.openlibrary.org/b/isbn/9780451524935-L.jpg',
            '9789722034142' => 'https://covers.openlibrary.org/b/isbn/9780547928227-L.jpg',
            '9789722034319' => 'https://covers.openlibrary.org/b/isbn/9780547928210-L.jpg',
            '9789722515771' => 'https://covers.openlibrary.org/b/isbn/9780062315007-L.jpg',
            '9789722018234' => 'https://covers.openlibrary.org/b/isbn/9780060883287-L.jpg',
            '9789896442668' => 'https://covers.openlibrary.org/b/isbn/9780062316097-L.jpg',
            '9789722528474' => 'https://covers.openlibrary.org/b/isbn/9780375842207-L.jpg',
            '9789722528948' => 'https://covers.openlibrary.org/b/isbn/9780451529060-L.jpg',
            '9789722528955' => 'https://covers.openlibrary.org/b/isbn/9780141439518-L.jpg',
        ];

        foreach ($books as $book) {
            if (!isset($coverUrls[$book->isbn])) {
                $this->warn("No cover URL for: {$book->title}");
                continue;
            }

            $url = $coverUrls[$book->isbn];
            $this->info("Downloading cover for: {$book->title}");

            try {
                $response = Http::withOptions([
                    'verify' => false,
                ])->timeout(30)->get($url);
                
                if ($response->successful() && strlen($response->body()) > 1000) {
                    $fileName = 'covers/' . uniqid() . '.jpg';
                    Storage::disk('public')->put('books/' . $fileName, $response->body());
                    
                    $book->update(['cover_image' => 'books/' . $fileName]);
                    $this->info("✓ Downloaded: {$book->title}");
                } else {
                    $this->error("✗ Failed: {$book->title} (invalid response)");
                }
            } catch (\Exception $e) {
                $this->error("✗ Failed: {$book->title} ({$e->getMessage()})");
            }

            sleep(1); 
        }

        $this->info('Done!');
    }
}