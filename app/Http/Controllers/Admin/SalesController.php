<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (auth()->check()) {
            auth()->user()->update(['last_viewed_sales_at' => now()]);
        }
        
        $query = Sale::with(['book', 'user']);

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('book', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            })->orWhereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $sales = $query->latest()->paginate(15);
        return view('library.admin.sales.index', compact('sales'));
    }



    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        $sale->load(['book', 'user']);
        return view('library.admin.sales.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Not implemented for now, sales are usually final records
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateStatus(Request $request, Sale $sale)
    {
        $validated = $request->validate([
            'type' => 'required|in:payment,delivery',
            'status' => 'required|string',
        ]);

        // Store old status for comparison
        $oldStatus = $validated['type'] === 'payment' ? $sale->payment_status : $sale->delivery_status;

        if ($validated['type'] === 'payment') {
            $sale->update(['payment_status' => $validated['status']]);
        } else {
            // Delivery Status Update
            $sale->update(['delivery_status' => $validated['status']]);

            // Handle Cancellation & Refund
            if ($validated['status'] === 'cancelled') {
                // Always Restore Stock on Cancellation
                $sale->book->increment('quantity', $sale->quantity);

                // Check if already refunded to avoid double refund
                // Only refund if payment was actually completed
                if ($sale->payment_status === 'completed') {
                    // Refund to wallet
                    $sale->user->increment('wallet_balance', $sale->total_amount);

                    // Update payment status to refunded
                    $sale->update(['payment_status' => 'refunded']);

                    // Log Refund Transaction
                    \App\Models\Transaction::create([
                        'user_id' => $sale->user_id,
                        'type' => 'credit',
                        'amount' => $sale->total_amount,
                        'description' => "Refund for cancelled order: {$sale->book->title}",
                    ]);
                }
            }
        }

        // Send email notification only if status actually changed
        if ($oldStatus !== $validated['status']) {
            try {
                \Mail::to($sale->user->email)->send(
                    new \App\Mail\SaleStatusUpdated($sale, $validated['type'], $validated['status'])
                );
            } catch (\Exception $e) {
                // Log the error but don't fail the status update
                \Log::error('Failed to send status update email: ' . $e->getMessage());
            }
        }

        return back()->with('success', ucfirst($validated['type']) . ' status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        // Restore quantity
        $sale->book->increment('quantity', $sale->quantity);
        $sale->delete();
        return redirect()->route('library.admin.sales.index')->with('success', 'Sale record deleted and stock restored.');
    }
}
