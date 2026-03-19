<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    /**
     * Display a listing of pending donations.
     */
    public function index()
    {
        $pendingBooks = Book::where('status', 'pending_approval')->with('donor')->latest()->paginate(10);
        $settings = [
            'donation_contact_name' => \App\Models\Setting::where('key', 'donation_contact_name')->value('value') ?? '',
            'donation_contact_number' => \App\Models\Setting::where('key', 'donation_contact_number')->value('value') ?? '',
            'donation_address' => \App\Models\Setting::where('key', 'donation_address')->value('value') ?? '',
            'donation_notes' => \App\Models\Setting::where('key', 'donation_notes')->value('value') ?? '',
        ];
        return view('library.admin.donations.index', compact('pendingBooks', 'settings'));
    }

    /**
     * Update the donation drop-off settings.
     */
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'donation_contact_name' => 'nullable|string|max:255',
            'donation_contact_number' => 'nullable|string|max:255',
            'donation_address' => 'nullable|string',
            'donation_notes' => 'nullable|string',
        ]);

        foreach ($validated as $key => $value) {
            \App\Models\Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'group' => 'donation', 'type' => 'text']
            );
        }

        return back()->with('success', 'Donation drop-off settings updated successfully.');
    }

    /**
     * Approve a donation.
     */
    public function approve(Book $book, Request $request)
    {
        // Validate request to ensure valid status transition
        if ($book->status !== 'pending_approval') {
            return back()->with('error', 'This book is not pending approval.');
        }

        $validated = $request->validate([
            'category' => 'required|string',
            'type' => 'required|in:rent,sale,both',
            'selling_price' => 'nullable|required_if:type,sale,both|numeric|min:0',
            'rental_price' => 'nullable|required_if:type,rent,both|numeric|min:0',
        ]);

        // Handle conditional pricing logic (if type is rent, selling_price should be 0, etc.)
        // The provided snippet removes this explicit logic, relying on nullable and the frontend to handle it.
        // If the frontend ensures that only relevant prices are sent, then this is fine.
        // Otherwise, the original logic might be needed. For now, I'll follow the provided snippet's structure.

        $book->update([
            'category' => $validated['category'],
            'type' => $validated['type'],
            'selling_price' => $validated['selling_price'] ?? null,
            'rental_price' => $validated['rental_price'] ?? null,
            'status' => 'available',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Book donation approved successfully.');
    }

    /**
     * Reject a donation.
     */
    public function reject(Book $book)
    {

        $book->update(['status' => 'rejected']);
        // Or $book->delete(); depending on requirements. Let's keep it 'rejected' for now.

        return back()->with('success', 'Donation rejected.');
    }

    /**
     * Show all approved/rejected donations with tracking details.
     */
    public function status()
    {
        $donations = Book::whereNotNull('donated_by')
            ->whereIn('status', ['available', 'rejected'])
            ->with(['donor', 'approver'])
            ->latest('approved_at')
            ->paginate(15);

        return view('library.admin.donations.status', compact('donations'));
    }
}
