@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8 relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-600 via-cyan-600 to-teal-600 p-8 shadow-2xl">
                <div class="absolute inset-0 bg-black/10"></div>
                <div class="relative z-10 flex items-center">
                    <div class="flex items-center gap-4">
                        <div class="p-4 bg-white/20 backdrop-blur-sm rounded-full">
                            <span class="material-symbols-outlined text-5xl text-white">book_2</span>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-white mb-1">Rental Management</h1>
                            <p class="text-white/90">Track all book rentals, returns, and late fees</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Total Rentals -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-xl">
                            <span class="material-symbols-outlined text-3xl text-blue-600 dark:text-blue-400">book_2</span>
                        </div>
                        <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Total Rentals</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">{{ \App\Models\Rental::count() }}</h3>
                </div>

                <!-- Active Rentals -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-indigo-100 dark:bg-indigo-900/30 rounded-xl">
                            <span class="material-symbols-outlined text-3xl text-indigo-600 dark:text-indigo-400">key</span>
                        </div>
                        <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Active</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">{{ \App\Models\Rental::active()->count() }}</h3>
                </div>

                <!-- Overdue Rentals -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 border-l-4 border-l-red-500">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-red-100 dark:bg-red-900/30 rounded-xl">
                            <span class="material-symbols-outlined text-3xl text-red-600 dark:text-red-400">warning</span>
                        </div>
                        <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Overdue</span>
                    </div>
                    <h3 class="text-2xl font-bold text-red-600 dark:text-red-400 mb-1">{{ \App\Models\Rental::overdue()->count() }}</h3>
                </div>

                <!-- Returned Rentals -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-xl">
                            <span class="material-symbols-outlined text-3xl text-green-600 dark:text-green-400">check_circle</span>
                        </div>
                        <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Returned</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">{{ \App\Models\Rental::returned()->count() }}</h3>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 mb-6">
                <form method="GET" action="{{ route('library.admin.rentals.index') }}" class="flex flex-wrap gap-4">
                    <!-- Status Filter -->
                    <div class="flex-1 min-w-[200px]">
                        <select name="status" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-blue-500 focus:ring-blue-500">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="overdue" {{ request('status') === 'overdue' ? 'selected' : '' }}>Overdue</option>
                            <option value="returned" {{ request('status') === 'returned' ? 'selected' : '' }}>Returned</option>
                        </select>
                    </div>

                    <!-- Search -->
                    <div class="flex-1 min-w-[300px]">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by book or user..." class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition-all">
                        Filter
                    </button>
                    <a href="{{ route('library.admin.rentals.index') }}" class="px-6 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-xl transition-all">
                        Reset
                    </a>
                </form>
            </div>

            @if($rentals->isEmpty())
                <!-- Empty State -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-12 text-center">
                    <span class="material-symbols-outlined text-6xl text-gray-400 mb-4">library_books</span>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No Rentals Found</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">No rental transactions have been recorded yet.</p>
                </div>
            @else
                <!-- Rentals Table -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-gray-700 dark:to-gray-800 border-b-2 border-blue-200 dark:border-gray-600">
                                    <th class="px-3 py-3 text-left text-[10px] font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wide">Book</th>
                                    <th class="px-3 py-3 text-left text-[10px] font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wide">Renter</th>
                                    <th class="px-3 py-3 text-left text-[10px] font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wide">Rental Date</th>
                                    <th class="px-3 py-3 text-left text-[10px] font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wide">Return Date</th>
                                    <th class="px-3 py-3 text-left text-[10px] font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wide">Payment</th>
                                    <th class="px-3 py-3 text-left text-[10px] font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wide">Delivery</th>
                                    <th class="px-3 py-3 text-left text-[10px] font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wide">Status</th>
                                    <th class="px-3 py-3 text-left text-[10px] font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wide">Overdue</th>
                                    <th class="px-3 py-3 text-left text-[10px] font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wide">Total</th>
                                    <th class="px-3 py-3 text-left text-[10px] font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wide">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                                @foreach($rentals as $rental)
                                    <tr class="hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-transparent dark:hover:from-gray-700/30 dark:hover:to-transparent transition-all duration-200 group">
                                        <!-- Book -->
                                        <td class="px-3 py-3">
                                            <div class="flex items-center gap-2">
                                                @if($rental->book->cover_image)
                                                    <img src="{{ asset('storage/' . $rental->book->cover_image) }}" alt="{{ $rental->book->title }}" class="w-10 h-14 object-cover rounded shadow-md group-hover:shadow-lg transition-shadow">
                                                @else
                                                    <div class="w-10 h-14 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 rounded flex items-center justify-center shadow-md">
                                                        <span class="material-symbols-outlined text-lg text-gray-400">book</span>
                                                    </div>
                                                @endif
                                                <div class="min-w-0">
                                                    <p class="text-xs font-semibold text-gray-900 dark:text-white truncate">{{ $rental->book->title }}</p>
                                                    <p class="text-[10px] text-gray-500 dark:text-gray-400 truncate">{{ $rental->book->author }}</p>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Renter -->
                                        <td class="px-3 py-3">
                                            <div class="flex items-center gap-2">
                                                <div class="w-7 h-7 rounded-full bg-gradient-to-br from-blue-400 to-cyan-500 flex items-center justify-center text-white text-xs font-bold shadow-md">
                                                    {{ strtoupper(substr($rental->user->name, 0, 1)) }}
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="text-xs font-medium text-gray-900 dark:text-white truncate">{{ $rental->user->name }}</p>
                                                    <p class="text-[10px] text-gray-500 dark:text-gray-400 truncate">{{ $rental->user->email }}</p>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Rental Date -->
                                        <td class="px-3 py-3">
                                            <div class="flex items-center gap-1">
                                                <span class="material-symbols-outlined text-blue-500 text-sm">calendar_today</span>
                                                <span class="text-[11px] font-medium text-gray-900 dark:text-white">{{ $rental->rental_date->format('M d, Y') }}</span>
                                            </div>
                                        </td>

                                        <!-- Return Date -->
                                        <td class="px-3 py-3">
                                            <div class="space-y-1">
                                                <div class="flex items-center gap-1">
                                                    <span class="material-symbols-outlined text-orange-500 text-sm">event</span>
                                                    <span class="text-[11px] text-gray-700 dark:text-gray-300">{{ $rental->expected_return_date->format('M d, Y') }}</span>
                                                </div>
                                                @if($rental->actual_return_date)
                                                    <div class="flex items-center gap-1">
                                                        <span class="material-symbols-outlined text-green-500 text-xs">check_circle</span>
                                                        <span class="text-[10px] text-green-600 dark:text-green-400 font-medium">{{ $rental->actual_return_date->format('M d, Y') }}</span>
                                                    </div>
                                                @elseif($rental->is_overdue)
                                                    <div class="flex items-center gap-1 px-1.5 py-0.5 bg-red-50 dark:bg-red-900/20 rounded w-fit">
                                                        <span class="material-symbols-outlined text-red-600 dark:text-red-400 text-xs">warning</span>
                                                        <span class="text-[10px] text-red-600 dark:text-red-400 font-bold">{{ $rental->days_overdue }}d late</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>

                                        <!-- Payment Status -->
                                        <td class="px-3 py-3">
                                            <form action="{{ route('library.admin.rentals.updatePaymentStatus', $rental) }}" method="POST" class="space-y-1">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status" onchange="this.form.submit()" class="block w-full pl-2 pr-6 py-1 text-[10px] font-medium border border-gray-200 dark:border-gray-600 focus:outline-none focus:ring-1 focus:ring-purple-500 rounded shadow-sm dark:bg-gray-700 dark:text-gray-200 cursor-pointer">
                                                    <option value="pending" {{ $rental->payment_status === 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                                    <option value="paid" {{ $rental->payment_status === 'paid' ? 'selected' : '' }}>✓ Paid</option>
                                                    <option value="failed" {{ $rental->payment_status === 'failed' ? 'selected' : '' }}>✗ Failed</option>
                                                </select>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-bold shadow-sm
                                                    {{ $rental->payment_status === 'paid' ? 'bg-gradient-to-r from-green-400 to-emerald-500 text-white' : 
                                                       ($rental->payment_status === 'failed' ? 'bg-gradient-to-r from-red-400 to-rose-500 text-white' : 'bg-gradient-to-r from-yellow-400 to-orange-500 text-white') }}">
                                                    {{ ucfirst($rental->payment_status) }}
                                                </span>
                                            </form>
                                        </td>

                                        <!-- Delivery Status -->
                                        <td class="px-3 py-3">
                                            <form action="{{ route('library.admin.rentals.updateDeliveryStatus', $rental) }}" method="POST" class="space-y-1">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status" onchange="this.form.submit()" class="block w-full pl-2 pr-6 py-1 text-[10px] font-medium border border-gray-200 dark:border-gray-600 focus:outline-none focus:ring-1 focus:ring-blue-500 rounded shadow-sm dark:bg-gray-700 dark:text-gray-200 cursor-pointer">
                                                    <option value="pending" {{ $rental->delivery_status === 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                                    <option value="dispatched" {{ $rental->delivery_status === 'dispatched' ? 'selected' : '' }}>📦 Dispatched</option>
                                                    <option value="on_the_way" {{ $rental->delivery_status === 'on_the_way' ? 'selected' : '' }}>🚚 On the Way</option>
                                                    <option value="delivered" {{ $rental->delivery_status === 'delivered' ? 'selected' : '' }}>✓ Delivered</option>
                                                    <option value="cancelled" {{ $rental->delivery_status === 'cancelled' ? 'selected' : '' }}>✗ Cancelled</option>
                                                    <option value="returned" {{ $rental->delivery_status === 'returned' ? 'selected' : '' }}>↩ Returned</option>
                                                </select>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-bold shadow-sm
                                                    {{ $rental->delivery_status === 'delivered' ? 'bg-gradient-to-r from-green-400 to-emerald-500 text-white' : 
                                                       ($rental->delivery_status === 'cancelled' ? 'bg-gradient-to-r from-red-400 to-rose-500 text-white' : 'bg-gradient-to-r from-blue-400 to-cyan-500 text-white') }}">
                                                    {{ ucwords(str_replace('_', ' ', $rental->delivery_status)) }}
                                                </span>
                                            </form>
                                        </td>

                                        <!-- Status -->
                                        <td class="px-3 py-3">
                                            @if($rental->status === 'returned')
                                                <span class="inline-flex items-center gap-1 px-2 py-1 bg-gradient-to-r from-green-400 to-emerald-500 text-white rounded-full text-[9px] font-bold shadow-md">
                                                    <span class="material-symbols-outlined text-xs">check_circle</span>
                                                    Returned
                                                </span>
                                            @elseif($rental->is_overdue)
                                                <span class="inline-flex items-center gap-1 px-2 py-1 bg-gradient-to-r from-red-500 to-rose-600 text-white rounded-full text-[9px] font-bold shadow-md animate-pulse">
                                                    <span class="material-symbols-outlined text-xs">warning</span>
                                                    Overdue
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2 py-1 bg-gradient-to-r from-blue-400 to-cyan-500 text-white rounded-full text-[9px] font-bold shadow-md">
                                                    <span class="material-symbols-outlined text-xs">schedule</span>
                                                    Active
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Overdue Fee -->
                                        <td class="px-3 py-3">
                                            @php
                                                $lateFee = $rental->status === 'returned' ? $rental->late_fee : $rental->calculated_late_fee;
                                            @endphp
                                            <div class="flex items-center gap-1">
                                                @if($lateFee > 0)
                                                    <div class="px-2 py-1 bg-gradient-to-r from-red-50 to-rose-50 dark:from-red-900/20 dark:to-rose-900/20 rounded border-l-2 border-red-500">
                                                        <p class="text-xs font-bold text-red-600 dark:text-red-400">₹ {{ number_format($lateFee, 2) }}</p>
                                                    </div>
                                                @else
                                                    <div class="px-2 py-1 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 rounded">
                                                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400">₹ 0.00</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>

                                        <!-- Total -->
                                        <td class="px-3 py-3">
                                            <div class="px-2 py-1 bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 rounded border-l-2 border-blue-500">
                                                <p class="text-xs font-bold text-gray-900 dark:text-white">₹{{ number_format($rental->status === 'returned' ? $rental->total_amount : ($rental->rental_price + $rental->calculated_late_fee), 2) }}</p>
                                                <p class="text-[9px] text-gray-500 dark:text-gray-400">Base: ₹{{ number_format($rental->rental_price, 2) }}</p>
                                            </div>
                                        </td>

                                        <!-- Actions -->
                                        <td class="px-3 py-3">
                                            <div class="flex items-center gap-1">
                                                <a href="{{ route('library.admin.rentals.show', $rental) }}" class="p-1.5 bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 dark:from-gray-700 dark:to-gray-600 dark:hover:from-gray-600 dark:hover:to-gray-500 rounded transition-all shadow-sm hover:shadow-md">
                                                    <span class="material-symbols-outlined text-gray-600 dark:text-gray-300 text-sm">visibility</span>
                                                </a>

                                                @if($rental->status !== 'returned')
                                                    <form method="POST" action="{{ route('library.admin.rentals.markReturned', $rental) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="inline-flex items-center gap-1 px-2 py-1 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white rounded text-[10px] font-semibold shadow-md hover:shadow-lg transition-all">
                                                            <span class="material-symbols-outlined text-sm">assignment_turned_in</span>
                                                            Mark Returned
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-400 dark:text-gray-500 rounded text-[10px] font-medium">
                                                        <span class="material-symbols-outlined text-sm">done_all</span>
                                                        Completed
                                                    </span>
                                                @endif
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
                    {{ $rentals->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
