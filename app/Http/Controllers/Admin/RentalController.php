<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RentalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (auth()->check()) {
            auth()->user()->update(['last_viewed_rentals_at' => now()]);
        }
        
        $query = Rental::with(['book', 'user']);

        // Filter by status
        if ($request->has('status')) {
            if ($request->status === 'active') {
                $query->active();
            } elseif ($request->status === 'overdue') {
                $query->overdue();
            } elseif ($request->status === 'returned') {
                $query->returned();
            }
        }

        // Search
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('book', function ($sq) use ($search) {
                    $sq->where('title', 'like', "%{$search}%");
                })->orWhereHas('user', function ($sq) use ($search) {
                    $sq->where('name', 'like', "%{$search}%");
                });
            });
        }

        $rentals = $query->latest()->paginate(15);

        return view('library.admin.rentals.index', compact('rentals'));
    }



    /**
     * Display the specified resource.
     */
    public function show(Rental $rental)
    {
        $rental->load(['book', 'user']);
        return view('library.admin.rentals.show', compact('rental'));
    }

    /**
     * Mark rental as returned and calculate late fees.
     */
    public function markReturned(Request $request, Rental $rental)
    {
        $returnDate = $request->input('return_date', now());
        $returnDate = Carbon::parse($returnDate);

        // Calculate late fee
        $lateFee = 0;
        if ($returnDate->gt($rental->expected_return_date)) {
            $daysOverdue = $returnDate->diffInDays($rental->expected_return_date);
            $lateFee = $daysOverdue * $rental->book->late_fee_per_day;
        }

        // Update rental
        $rental->update([
            'actual_return_date' => $returnDate,
            'late_fee' => $lateFee,
            'total_amount' => $rental->rental_price + $lateFee,
            'status' => 'returned',
        ]);

        // Increment book quantity
        $rental->book->increment('quantity');

        // Send thank you email
        try {
            \Mail::to($rental->user->email)->send(
                new \App\Mail\RentalReturnedThankYou($rental)
            );
        } catch (\Exception $e) {
            // Log the error but don't fail the return process
            \Log::error('Failed to send rental return thank you email: ' . $e->getMessage());
        }

        return back()->with('success', 'Rental marked as returned. Late fee: ₹' . number_format($lateFee, 2));
    }

    /**
     * Update payment status.
     */
    public function updatePaymentStatus(Request $request, Rental $rental)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,paid,failed',
        ]);

        // Store old status for comparison
        $oldStatus = $rental->payment_status;

        $rental->update(['payment_status' => $validated['status']]);

        // Send email notification only if status actually changed
        if ($oldStatus !== $validated['status']) {
            try {
                \Mail::to($rental->user->email)->send(
                    new \App\Mail\RentalStatusUpdated($rental, 'payment', $validated['status'])
                );
            } catch (\Exception $e) {
                // Log the error but don't fail the status update
                \Log::error('Failed to send rental payment status email: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Payment status updated successfully!');
    }

    /**
     * Update delivery status.
     */
    public function updateDeliveryStatus(Request $request, Rental $rental)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,dispatched,on_the_way,delivered,cancelled,returned',
        ]);

        // Store old status for comparison
        $oldStatus = $rental->delivery_status;

        $rental->update(['delivery_status' => $validated['status']]);

        // Handle Delivery Cancellation
        if ($validated['status'] === 'cancelled' && $oldStatus !== 'cancelled') {
             // 1. Restore the book stock
            $rental->book->increment('quantity');

            // 2. Process Refund if paid
            if ($rental->payment_status === 'paid') {
                $rental->user->increment('wallet_balance', $rental->total_amount);
                
                $rental->update(['payment_status' => 'refunded']);

                \App\Models\Transaction::create([
                    'user_id' => $rental->user_id,
                    'type' => 'credit',
                    'amount' => $rental->total_amount,
                    'description' => "Refund for cancelled rental: {$rental->book->title}",
                ]);
            }
        }

        // Send email notification only if status actually changed
        if ($oldStatus !== $validated['status']) {
            try {
                \Mail::to($rental->user->email)->send(
                    new \App\Mail\RentalStatusUpdated($rental, 'delivery', $validated['status'])
                );
            } catch (\Exception $e) {
                // Log the error but don't fail the status update
                \Log::error('Failed to send rental delivery status email: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Delivery status updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rental $rental)
    {
        // Only allow deletion of returned rentals
        if ($rental->status !== 'returned') {
            return back()->with('error', 'Cannot delete active rental.');
        }

        $rental->delete();

        return redirect()->route('library.admin.rentals.index')->with('success', 'Rental deleted successfully!');
    }
}
