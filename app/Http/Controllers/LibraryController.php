<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LibraryController extends Controller
{
    public function index()
    {
        $books = \App\Models\Book::whereNotIn('status', ['unavailable', 'lost'])->latest()->get();
        $app_name = \App\Models\Setting::where('key', 'app_name')->value('value') ?? 'RuralEmpower';

        $missingFields = [];
        if (Auth::check()) {
            $user = Auth::user();
            $requiredFields = ['name' => 'Full Name', 'email' => 'Email Address', 'phone' => 'Phone Number', 'address' => 'Address'];
            foreach ($requiredFields as $field => $label) {
                if (empty($user->$field)) {
                    $missingFields[] = $label;
                }
            }
        }

        $categories = \App\Models\Category::all();

        return view('library.index', compact('books', 'app_name', 'missingFields', 'categories'));
    }

    public function show($category, $slug)
    {
        $book = \App\Models\Book::where('slug', $slug)->first();

        // Fallback for old links or if accessed by ID
        if (!$book && is_numeric($slug)) {
            $book = \App\Models\Book::find($slug);
        }

        if (!$book || in_array($book->status, ['unavailable', 'lost'])) {
            abort(404);
        }

        $missingFields = [];
        if (Auth::check()) {
            $user = Auth::user();
            $requiredFields = ['name' => 'Full Name', 'email' => 'Email Address', 'phone' => 'Phone Number', 'address' => 'Address'];
            foreach ($requiredFields as $field => $label) {
                if (empty($user->$field)) {
                    $missingFields[] = $label;
                }
            }
        }

        return view('library.show', compact('book', 'missingFields'));
    }


    public function admin()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        return view('library.admin.index');
    }

    public function user()
    {
        $user = Auth::user();
        $rentals = \App\Models\Rental::where('user_id', $user->id)->with('book')->latest()->get();
        $purchases = \App\Models\Sale::where('user_id', $user->id)->with('book')->latest()->get();
        $donations = \App\Models\Book::where('donated_by', $user->id)->latest()->get();

        return view('library.user.index', compact('rentals', 'purchases', 'donations'));
    }

    public function orders()
    {
        $user = Auth::user();
        $orders = \App\Models\Sale::where('user_id', $user->id)->with('book')->latest()->get();
        return view('library.user.orders', compact('orders'));
    }

    public function rentals()
    {
        $user = Auth::user();
        $rentals = \App\Models\Rental::where('user_id', $user->id)->with('book')->latest()->get();
        return view('library.user.rentals', compact('rentals'));
    }
}
