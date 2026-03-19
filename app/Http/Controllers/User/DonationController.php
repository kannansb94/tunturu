<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DonationController extends Controller
{
    /**
     * Show the donation form.
     */
    public function create()
    {
        $settings = [
            'donation_contact_name' => \App\Models\Setting::where('key', 'donation_contact_name')->value('value') ?? '',
            'donation_contact_number' => \App\Models\Setting::where('key', 'donation_contact_number')->value('value') ?? '',
            'donation_address' => \App\Models\Setting::where('key', 'donation_address')->value('value') ?? '',
            'donation_notes' => \App\Models\Setting::where('key', 'donation_notes')->value('value') ?? '',
        ];
        return view('library.user.donate', compact('settings'));
    }

    /**
     * Store a new book donation.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        // Handle cover image upload
        $coverImagePath = null;
        if ($request->hasFile('cover_image')) {
            $coverImagePath = $request->file('cover_image')->store('books/covers', 'public');
        }

        // Create book with pending_approval status
        Book::create([
            'title' => $validated['title'],
            'author' => $validated['author'],
            'isbn' => $validated['isbn'],
            'description' => $validated['description'],
            'cover_image' => $coverImagePath,
            'status' => 'pending_approval',
            'donated_by' => auth()->id(),
            'donor_location' => auth()->user()->address ?? 'Not specified',
            'quantity' => 1,
            'category' => 'Uncategorized', // Will be set by admin during approval
            'type' => 'rent', // Default, will be set by admin
        ]);

        return redirect()->route('library.user')->with('success', 'Thank you for your donation! Your book is pending admin approval.');
    }

    /**
     * Show user's donation status.
     */
    public function status()
    {
        $donations = Book::where('donated_by', auth()->id())
            ->with(['donor', 'approver'])
            ->latest()
            ->paginate(10);

        return view('library.user.donation-status', compact('donations'));
    }
}
