<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featured_books = Book::with(['category', 'authors'])
            ->where('available_quantity', '>', 0)
            ->latest()
            ->take(8)
            ->get();

        $categories = Category::withCount('books')
            ->orderBy('name')
            ->get();

        return view('public.home', compact('featured_books', 'categories'));
    }

    public function books(Request $request)
    {
        $query = Book::with(['category', 'authors']);

        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%")
                  ->orWhereHas('authors', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->has('available') && $request->available) {
            $query->where('available_quantity', '>', 0);
        }

        $books = $query->latest()->paginate(12);
        $categories = Category::orderBy('name')->get();

        return view('public.books', compact('books', 'categories'));
    }

    public function show(Book $book)
    {
        $book->load(['category', 'authors', 'loans' => function($query) {
            $query->where('status', 'active');
        }]);

        $related_books = Book::with(['category', 'authors'])
            ->where('category_id', $book->category_id)
            ->where('id', '!=', $book->id)
            ->where('available_quantity', '>', 0)
            ->take(4)
            ->get();

        return view('public.book-detail', compact('book', 'related_books'));
    }

    public function search(Request $request)
    {
        $search = $request->input('q');
        
        $books = Book::with(['category', 'authors'])
            ->where('title', 'like', "%{$search}%")
            ->orWhere('isbn', 'like', "%{$search}%")
            ->orWhereHas('authors', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })
            ->paginate(12);

        return view('public.search', compact('books', 'search'));
    }
}