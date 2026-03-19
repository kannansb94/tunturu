@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8 relative overflow-hidden rounded-2xl bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 p-8 shadow-2xl">
                <div class="absolute inset-0 bg-black/10"></div>
                <div class="relative z-10 flex items-center">
                    <div class="flex items-center gap-4">
                        <div class="p-4 bg-white/20 backdrop-blur-sm rounded-full">
                            <span class="material-symbols-outlined text-5xl text-white">shopping_cart</span>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-white mb-1">Sales Management</h1>
                            <p class="text-white/90">Track all book sales and revenue</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 mb-6">
                <form method="GET" action="{{ route('library.admin.sales.index') }}" class="flex flex-wrap gap-4">
                    <!-- Search -->
                    <div class="flex-1 min-w-[300px]">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by book or user..." class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-emerald-500 focus:ring-emerald-500">
                    </div>

                    <button type="submit" class="px-6 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl transition-all">
                        Filter
                    </button>
                    <a href="{{ route('library.admin.sales.index') }}" class="px-6 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-xl transition-all">
                        Reset
                    </a>
                </form>
            </div>

            @if($sales->isEmpty())
                <!-- Empty State -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-12 text-center">
                    <span class="material-symbols-outlined text-6xl text-gray-400 mb-4">shopping_bag</span>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No Sales Found</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">No sales transactions have been recorded yet.</p>
                </div>
            @else
                <!-- Sales Table -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="bg-gradient-to-r from-purple-50 to-pink-50 dark:from-gray-700 dark:to-gray-800 border-b-2 border-purple-200 dark:border-gray-600">
                                    <th class="px-3 py-3 text-left text-[10px] font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wide">Book</th>
                                    <th class="px-3 py-3 text-left text-[10px] font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wide">Buyer</th>
                                    <th class="px-3 py-3 text-left text-[10px] font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wide">Date</th>
                                    <th class="px-3 py-3 text-left text-[10px] font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wide">Qty</th>
                                    <th class="px-3 py-3 text-left text-[10px] font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wide">Amount</th>
                                    <th class="px-3 py-3 text-left text-[10px] font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wide">Payment</th>
                                    <th class="px-3 py-3 text-left text-[10px] font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wide">Delivery</th>
                                    <th class="px-3 py-3 text-left text-[10px] font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wide">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                                @foreach($sales as $sale)
                                    <tr class="hover:bg-gradient-to-r hover:from-purple-50/50 hover:to-transparent dark:hover:from-gray-700/30 dark:hover:to-transparent transition-all duration-200 group">
                                        <!-- Book -->
                                        <td class="px-3 py-3">
                                            <div class="flex items-center gap-2">
                                                @if($sale->book->cover_image)
                                                    <img src="{{ asset('storage/' . $sale->book->cover_image) }}" alt="{{ $sale->book->title }}" class="w-10 h-14 object-cover rounded shadow-md group-hover:shadow-lg transition-shadow">
                                                @else
                                                    <div class="w-10 h-14 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 rounded flex items-center justify-center shadow-md">
                                                        <span class="material-symbols-outlined text-lg text-gray-400">book</span>
                                                    </div>
                                                @endif
                                                <div class="min-w-0">
                                                    <p class="text-xs font-semibold text-gray-900 dark:text-white truncate">{{ $sale->book->title }}</p>
                                                    <p class="text-[10px] text-gray-500 dark:text-gray-400 truncate">{{ $sale->book->author }}</p>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Buyer -->
                                        <td class="px-3 py-3">
                                            <div class="flex items-center gap-2">
                                                <div class="w-7 h-7 rounded-full bg-gradient-to-br from-purple-400 to-pink-500 flex items-center justify-center text-white text-xs font-bold shadow-md">
                                                    {{ strtoupper(substr($sale->user->name, 0, 1)) }}
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="text-xs font-medium text-gray-900 dark:text-white truncate">{{ $sale->user->name }}</p>
                                                    <p class="text-[10px] text-gray-500 dark:text-gray-400 truncate">{{ $sale->user->email }}</p>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Date -->
                                        <td class="px-3 py-3">
                                            <div class="flex items-center gap-1">
                                                <span class="material-symbols-outlined text-purple-500 text-sm">calendar_today</span>
                                                <span class="text-[11px] font-medium text-gray-900 dark:text-white">{{ $sale->sale_date->format('M d, Y') }}</span>
                                            </div>
                                        </td>

                                        <!-- Quantity -->
                                        <td class="px-3 py-3">
                                            <div class="px-2 py-1 bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded border-l-2 border-indigo-500 w-fit">
                                                <p class="text-xs font-bold text-gray-900 dark:text-white">{{ $sale->quantity }}</p>
                                            </div>
                                        </td>

                                        <!-- Total Amount -->
                                        <td class="px-3 py-3">
                                            <div class="px-2 py-1 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded border-l-2 border-purple-500">
                                                <p class="text-xs font-bold text-gray-900 dark:text-white">₹{{ number_format($sale->total_amount, 2) }}</p>
                                                <p class="text-[9px] text-gray-500 dark:text-gray-400">₹{{ number_format($sale->price_per_unit, 2) }}/u</p>
                                            </div>
                                        </td>

                                        <!-- Payment Status -->
                                        <td class="px-3 py-3">
                                            <form action="{{ route('library.admin.sales.updateStatus', $sale) }}" method="POST" class="space-y-1">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="type" value="payment">
                                                <select name="status" onchange="this.form.submit()" class="block w-full pl-2 pr-6 py-1 text-[10px] font-medium border border-gray-200 dark:border-gray-600 focus:outline-none focus:ring-1 focus:ring-green-500 rounded shadow-sm dark:bg-gray-700 dark:text-gray-200 cursor-pointer">
                                                    <option value="pending" {{ $sale->payment_status === 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                                    <option value="completed" {{ $sale->payment_status === 'completed' ? 'selected' : '' }}>✓ Completed</option>
                                                    <option value="refunded" {{ $sale->payment_status === 'refunded' ? 'selected' : '' }}>↩ Refunded</option>
                                                </select>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-bold shadow-sm
                                                    {{ $sale->payment_status === 'completed' ? 'bg-gradient-to-r from-green-400 to-emerald-500 text-white' : 
                                                       ($sale->payment_status === 'refunded' ? 'bg-gradient-to-r from-red-400 to-rose-500 text-white' : 'bg-gradient-to-r from-yellow-400 to-orange-500 text-white') }}">
                                                    {{ ucfirst($sale->payment_status) }}
                                                </span>
                                            </form>
                                        </td>

                                        <!-- Delivery Status -->
                                        <td class="px-3 py-3">
                                            <form action="{{ route('library.admin.sales.updateStatus', $sale) }}" method="POST" class="space-y-1">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="type" value="delivery">
                                                <select name="status" onchange="this.form.submit()" class="block w-full pl-2 pr-6 py-1 text-[10px] font-medium border border-gray-200 dark:border-gray-600 focus:outline-none focus:ring-1 focus:ring-blue-500 rounded shadow-sm dark:bg-gray-700 dark:text-gray-200 cursor-pointer">
                                                    <option value="pending" {{ $sale->delivery_status === 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                                    <option value="dispatched" {{ $sale->delivery_status === 'dispatched' ? 'selected' : '' }}>📦 Dispatched</option>
                                                    <option value="on_the_way" {{ $sale->delivery_status === 'on_the_way' ? 'selected' : '' }}>🚚 On the Way</option>
                                                    <option value="delivered" {{ $sale->delivery_status === 'delivered' ? 'selected' : '' }}>✓ Delivered</option>
                                                    <option value="cancelled" {{ $sale->delivery_status === 'cancelled' ? 'selected' : '' }}>✗ Cancelled</option>
                                                </select>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-bold shadow-sm
                                                    {{ $sale->delivery_status === 'delivered' ? 'bg-gradient-to-r from-green-400 to-emerald-500 text-white' : 
                                                       ($sale->delivery_status === 'cancelled' ? 'bg-gradient-to-r from-red-400 to-rose-500 text-white' : 'bg-gradient-to-r from-blue-400 to-cyan-500 text-white') }}">
                                                    {{ ucwords(str_replace('_', ' ', $sale->delivery_status)) }}
                                                </span>
                                            </form>
                                        </td>

                                        <!-- Actions -->
                                        <td class="px-3 py-3">
                                            <div class="flex items-center gap-1">
                                                <a href="{{ route('library.admin.sales.show', $sale) }}" class="p-1.5 bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 dark:from-gray-700 dark:to-gray-600 dark:hover:from-gray-600 dark:hover:to-gray-500 rounded transition-all shadow-sm hover:shadow-md">
                                                    <span class="material-symbols-outlined text-gray-600 dark:text-gray-300 text-sm">visibility</span>
                                                </a>
                                                <form method="POST" action="{{ route('library.admin.sales.destroy', $sale) }}" onsubmit="return confirm('Are you sure? This will restore the stock.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-1.5 bg-gradient-to-r from-red-100 to-rose-100 hover:from-red-200 hover:to-rose-200 dark:from-red-900/30 dark:to-rose-900/30 dark:hover:from-red-900/50 dark:hover:to-rose-900/50 rounded transition-all shadow-sm hover:shadow-md">
                                                        <span class="material-symbols-outlined text-red-600 dark:text-red-400 text-sm">delete</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $sales->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
