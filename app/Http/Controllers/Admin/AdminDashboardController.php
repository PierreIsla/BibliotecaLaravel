<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use App\Models\Loan;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_books' => Book::count(),
            'total_authors' => Author::count(),
            'total_categories' => Category::count(),
            'total_users' => User::where('role', 'user')->count(),
            'active_loans' => Loan::where('status', 'active')->count(),
            'overdue_loans' => Loan::where('status', 'overdue')->count(),
            'available_books' => Book::where('available_quantity', '>', 0)->count(),
        ];

        $recent_loans = Loan::with(['book', 'user'])
            ->latest()
            ->take(10)
            ->get();

        $overdue_loans = Loan::with(['book', 'user'])
            ->where('status', 'active')
            ->where('due_date', '<', now())
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_loans', 'overdue_loans'));
    }
}