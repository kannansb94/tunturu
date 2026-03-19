<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // View Cart Page
    public function index()
    {
        $userId = Auth::id();
        $cartItems = Cart::where('user_id', $userId)->with('book')->get();

        $totalRent = 0;
        $totalBuy = 0;

        foreach ($cartItems as $item) {
            if (!$item->book) continue;
            
            if ($item->type === 'rent') {
                $totalRent += $item->book->rental_price * $item->quantity;
            } else {
                $totalBuy += $item->book->selling_price * $item->quantity;
            }
        }

        $total = $totalRent + $totalBuy;

        return view('library.cart', compact('cartItems', 'totalRent', 'totalBuy', 'total'));
    }

    // Add to Cart
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'action'  => 'required|in:buy,rent',
        ]);

        $book = Book::findOrFail($request->book_id);
        
        // Ensure book isn't unavailable
        if (in_array($book->status, ['unavailable', 'lost'])) {
            return back()->with('error', 'This book is not available.');
        }

        $userId = Auth::id();

        // Check if it already exists
        $existing = Cart::where('user_id', $userId)
                        ->where('book_id', $book->id)
                        ->where('type', $request->action)
                        ->first();

        if ($existing) {
            // Because buying physical books usually implies 1 per person in a library setting, 
            // we will just say it's already in the cart rather than increasing quantity
            if ($request->has('checkout_now')) {
                return redirect()->route('library.checkout');
            }
            return back()->with('success', 'Book is already in your cart.');
        }

        Cart::create([
            'user_id'  => $userId,
            'book_id'  => $book->id,
            'type'     => $request->action,
            'quantity' => 1,
        ]);

        if ($request->has('checkout_now')) {
            return redirect()->route('library.checkout');
        }

        return redirect()->route('library.cart.index')->with('success', 'Added to cart!');
    }

    // Remove from Cart
    public function destroy($id)
    {
        $cartItem = Cart::where('user_id', Auth::id())->findOrFail($id);
        $cartItem->delete();

        return back()->with('success', 'Item removed from cart.');
    }
}
