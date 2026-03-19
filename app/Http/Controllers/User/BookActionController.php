<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Cart;
use App\Models\Sale;
use App\Models\Rental;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Razorpay\Api\Api as RazorpayApi;

class BookActionController extends Controller
{
    // Show Checkout Page (Now handles the entire Cart)
    public function checkout(Request $request)
    {
        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->with('book')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('library.index')->with('error', 'Your cart is empty.');
        }

        $totalRent = 0;
        $totalBuy = 0;
        $hasOutOfStock = false;

        foreach ($cartItems as $item) {
            if (!$item->book) continue;
            
            if ($item->book->quantity < 1) {
                $hasOutOfStock = true;
                break;
            }

            if ($item->type === 'rent') {
                $totalRent += $item->book->rental_price * $item->quantity;
            } else {
                $totalBuy += $item->book->selling_price * $item->quantity;
            }
        }

        if ($hasOutOfStock) {
            return redirect()->route('library.cart.index')->with('error', 'Please remove out-of-stock items from your cart before checking out.');
        }

        $totalPrice = $totalRent + $totalBuy;
        $razorpayKeyId = config('services.razorpay.key_id');

        return view('library.checkout', compact('cartItems', 'totalPrice', 'user', 'razorpayKeyId'));
    }

    // Create a Razorpay Order
    public function createRazorpayOrder(Request $request)
    {
        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->with('book')->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Cart is empty.'], 400);
        }

        $totalPrice = 0;
        foreach ($cartItems as $item) {
            if ($item->book && $item->book->quantity >= 1) {
                if ($item->type === 'rent') {
                    $totalPrice += $item->book->rental_price * $item->quantity;
                } else {
                    $totalPrice += $item->book->selling_price * $item->quantity;
                }
            }
        }

        try {
            $api = new RazorpayApi(
                config('services.razorpay.key_id'),
                config('services.razorpay.key_secret')
            );

            $order = $api->order->create([
                'amount'   => (int) round($totalPrice * 100), // in paise
                'currency' => 'INR',
                'receipt'  => 'order_' . uniqid(),
                'notes'    => [
                    'user_id' => $user->id,
                    'cart_checkout' => true
                ],
            ]);

            return response()->json([
                'success'           => true,
                'razorpay_order_id' => $order['id'],
                'amount'            => $order['amount'],
                'currency'          => $order['currency'],
            ]);
        } catch (\Exception $e) {
            Log::error('Razorpay order creation failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Could not initiate payment.'], 500);
        }
    }

    // Verify Online Payment & Process Orders
    public function verifyOnlinePayment(Request $request)
    {
        $request->validate([
            'razorpay_order_id'    => 'required|string',
            'razorpay_payment_id'  => 'required|string',
            'razorpay_signature'   => 'required|string',
            'delivery_name'        => 'required|string|max:255',
            'delivery_phone'       => 'required|string|max:20',
            'delivery_address'     => 'required|string|max:1000',
        ]);

        try {
            $api = new RazorpayApi(
                config('services.razorpay.key_id'),
                config('services.razorpay.key_secret')
            );

            $api->utility->verifyPaymentSignature([
                'razorpay_order_id'   => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature'  => $request->razorpay_signature,
            ]);
        } catch (\Exception $e) {
            Log::error('Razorpay verification failed: ' . $e->getMessage());
            return redirect()->route('library.checkout')->with('error', 'Payment verification failed.');
        }

        return $this->processCartCheckout($request, 'online', 'completed', $request->razorpay_payment_id);
    }

    // Process COD Payment
    public function process(Request $request)
    {
        $request->validate([
            'payment_method'   => 'required|in:cod',
            'delivery_name'    => 'required|string|max:255',
            'delivery_phone'   => 'required|string|max:20',
            'delivery_address' => 'required|string|max:1000',
        ]);

        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->with('book')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('library.index')->with('error', 'Cart is empty.');
        }

        $totalPrice = 0;
        foreach ($cartItems as $item) {
            if ($item->book && $item->book->quantity >= 1) {
                if ($item->type === 'rent') {
                    $totalPrice += $item->book->rental_price * $item->quantity;
                } else {
                    $totalPrice += $item->book->selling_price * $item->quantity;
                }
            }
        }

        return $this->processCartCheckout($request, $request->payment_method, 'pending');
    }

    // Shared Checkout Logic for Cart items
    private function processCartCheckout(Request $request, $paymentMethod, $paymentStatus, $paymentId = null)
    {
        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->with('book')->get();

        try {
            DB::beginTransaction();
            $orderIds = [];

            foreach ($cartItems as $item) {
                $book = $item->book;
                if (!$book || $book->quantity < $item->quantity) {
                    DB::rollBack();
                    return redirect()->route('library.cart.index')->with('error', "Book '{$book->title}' is out of stock.");
                }

                $price = $item->type === 'rent' ? $book->rental_price : $book->selling_price;
                $lineTotal = $price * $item->quantity;

                if ($item->type === 'buy') {
                    $sale = Sale::create([
                        'book_id'          => $book->id,
                        'user_id'          => $user->id,
                        'sale_date'        => now(),
                        'quantity'         => $item->quantity,
                        'price_per_unit'   => $price,
                        'total_amount'     => $lineTotal,
                        'status'           => 'completed',
                        'payment_method'   => $paymentMethod,
                        'payment_status'   => $paymentStatus,
                        'delivery_status'  => 'pending',
                        'delivery_name'    => $request->delivery_name,
                        'delivery_phone'   => $request->delivery_phone,
                        'delivery_address' => $request->delivery_address,
                    ]);
                    $orderIds[] = $sale->id;

                    $desc = "{$paymentMethod} payment for purchase of: {$book->title}";
                    if ($paymentId) $desc .= " (Razorpay ID: {$paymentId})";

                    Transaction::create([
                        'user_id'     => $user->id,
                        'type'        => 'debit',
                        'amount'      => $lineTotal,
                        'description' => $desc,
                    ]);

                    $admins = \App\Models\User::where('role', 'admin')->get();
                    \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\NewOrderNotification($sale));
                    $user->notify(new \App\Notifications\OrderConfirmationNotification($sale));

                } else {
                    $rental = Rental::create([
                        'book_id'              => $book->id,
                        'user_id'              => $user->id,
                        'rental_date'          => now(),
                        'expected_return_date' => now()->addDays(14),
                        'rental_price'         => $price,
                        'late_fee'             => 0,
                        'total_amount'         => $lineTotal,
                        'status'               => 'active',
                        'payment_status'       => $paymentStatus === 'completed' ? 'paid' : $paymentStatus,
                        'delivery_name'        => $request->delivery_name,
                        'delivery_phone'       => $request->delivery_phone,
                        'delivery_address'     => $request->delivery_address,
                    ]);
                    $orderIds[] = $rental->id;

                    $desc = "{$paymentMethod} payment for rental of: {$book->title}";
                    if ($paymentId) $desc .= " (Razorpay ID: {$paymentId})";

                    Transaction::create([
                        'user_id'     => $user->id,
                        'type'        => 'debit',
                        'amount'      => $lineTotal,
                        'description' => $desc,
                    ]);

                    $admins = \App\Models\User::where('role', 'admin')->get();
                    \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\NewRentalNotification($rental));
                    $user->notify(new \App\Notifications\RentalConfirmationNotification($rental));
                }

                $book->decrement('quantity', $item->quantity);
            }

            // Clear the cart
            Cart::where('user_id', $user->id)->delete();

            DB::commit();

            return redirect()->route('library.thank-you')
                ->with('order_ids', $orderIds);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout processing failed: ' . $e->getMessage());
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function thankYou()
    {
        return view('library.thank-you');
    }
}
