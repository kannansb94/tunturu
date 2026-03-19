<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Shopping Cart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-500/10 border border-green-500/50 text-green-400 rounded-xl flex items-center gap-3">
                    <span class="material-symbols-outlined">check_circle</span>
                    <p class="font-bold">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-500/10 border border-red-500/50 text-red-400 rounded-xl flex items-center gap-3">
                    <span class="material-symbols-outlined">error</span>
                    <p class="font-bold">{{ session('error') }}</p>
                </div>
            @endif

            @if($cartItems->isEmpty())
                <div class="bg-white dark:bg-surface-dark overflow-hidden shadow-sm sm:rounded-2xl p-12 text-center border border-white/10">
                    <span class="material-symbols-outlined text-gray-400 text-6xl mb-4">shopping_cart</span>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Your Cart is Empty</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-8">Looks like you haven't added anything to your cart yet.</p>
                    <a href="{{ route('library.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-primary to-primary-hover text-white font-bold rounded-xl shadow-lg hover:shadow-primary/30 transition-all">
                        Browse Library
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Cart Items -->
                    <div class="lg:col-span-2 space-y-4">
                        <div class="bg-white dark:bg-surface-dark overflow-hidden shadow-sm sm:rounded-2xl p-6 border border-white/10">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 border-b border-gray-200 dark:border-white/10 pb-4">
                                Cart Items ({{ $cartItems->count() }})
                            </h3>

                            <div class="space-y-6">
                                @foreach($cartItems as $item)
                                    @if($item->book)
                                        <div class="flex flex-col sm:flex-row gap-4 py-4 {{ !$loop->last ? 'border-b border-gray-200 dark:border-white/10' : '' }}">
                                            <!-- Image -->
                                            <div class="shrink-0">
                                                @if($item->book->cover_image)
                                                    <img src="{{ asset('storage/' . $item->book->cover_image) }}" alt="{{ $item->book->title }}"
                                                        class="w-24 h-32 object-cover rounded-lg shadow-md border border-white/5">
                                                @else
                                                    <div class="w-24 h-32 bg-gray-100 dark:bg-gray-800 rounded-lg flex items-center justify-center border border-white/5">
                                                        <span class="material-symbols-outlined text-3xl text-gray-400">book</span>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Info -->
                                            <div class="flex-1 flex flex-col">
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <h4 class="text-lg font-bold text-gray-900 dark:text-white leading-tight mb-1">{{ $item->book->title }}</h4>
                                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $item->book->author }}</p>
                                                    </div>
                                                    
                                                    <form action="{{ route('library.cart.destroy', $item->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors p-1" title="Remove from cart">
                                                            <span class="material-symbols-outlined">delete</span>
                                                        </button>
                                                    </form>
                                                </div>

                                                <div class="mt-2 flex items-center gap-2">
                                                    <span class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider rounded-full {{ $item->type === 'rent' ? 'bg-primary/20 text-primary' : 'bg-secondary/20 text-secondary' }}">
                                                        {{ ucfirst($item->type) }}
                                                    </span>
                                                    @if($item->book->quantity < 1)
                                                        <span class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider rounded-full bg-red-500/20 text-red-500 flex items-center gap-1">
                                                            <span class="material-symbols-outlined text-[12px]">warning</span>
                                                            Out of Stock
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="mt-auto pt-4 flex justify-between items-center">
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                                        Qty: {{ $item->quantity }}
                                                    </div>
                                                    <div class="text-lg font-bold {{ $item->type === 'rent' ? 'text-primary' : 'text-secondary' }}">
                                                        ₹{{ number_format($item->type === 'rent' ? $item->book->rental_price : $item->book->selling_price, 2) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-white dark:bg-surface-dark overflow-hidden shadow-sm sm:rounded-2xl p-6 border border-white/10 sticky top-24">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Order Summary</h3>

                            <div class="space-y-3 mb-6">
                                @if($totalRent > 0)
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500 dark:text-gray-400">Total Rentals</span>
                                        <span class="font-medium text-gray-900 dark:text-white">₹{{ number_format($totalRent, 2) }}</span>
                                    </div>
                                @endif
                                
                                @if($totalBuy > 0)
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500 dark:text-gray-400">Total Purchases</span>
                                        <span class="font-medium text-gray-900 dark:text-white">₹{{ number_format($totalBuy, 2) }}</span>
                                    </div>
                                @endif

                                <div class="border-t border-gray-200 dark:border-gray-700/50 pt-3 flex justify-between">
                                    <span class="font-bold text-gray-900 dark:text-white">Subtotal</span>
                                    <span class="font-bold text-gray-900 dark:text-white">₹{{ number_format($total, 2) }}</span>
                                </div>
                            </div>
                            
                            @php
                                $hasOutOfStock = $cartItems->contains(function ($item) {
                                    return $item->book && $item->book->quantity < 1;
                                });
                            @endphp

                            @if($hasOutOfStock)
                                <div class="mb-4 p-3 bg-red-500/10 border border-red-500/20 rounded-xl relative">
                                    <p class="text-xs text-red-500 font-medium">One or more items in your cart are out of stock. Please remove them to proceed to checkout.</p>
                                </div>
                                <button disabled class="w-full py-3.5 bg-gray-300 dark:bg-gray-700 text-gray-500 dark:text-gray-400 font-bold rounded-xl cursor-not-allowed flex items-center justify-center gap-2">
                                    Checkout Unavailable
                                </button>
                            @else
                                <a href="{{ route('library.checkout') }}" class="w-full py-3.5 bg-gradient-to-r from-pink-500 via-purple-500 to-indigo-500 bg-[length:200%_auto] hover:bg-[position:right_center] text-white font-bold rounded-xl shadow-[0_4px_20px_rgba(168,85,247,0.4)] hover:shadow-[0_8px_30px_rgba(168,85,247,0.6)] hover:-translate-y-1 transition-all duration-500 flex items-center justify-center gap-2 relative overflow-hidden group">
                                    <span class="relative z-10 flex items-center gap-2">
                                        Proceed to Checkout
                                        <span class="material-symbols-outlined">arrow_forward</span>
                                    </span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
