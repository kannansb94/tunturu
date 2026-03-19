@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8 print:hidden">
                <a href="{{ route('library.admin.rentals.index') }}"
                    class="inline-flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white mb-4">
                    <span class="material-symbols-outlined">arrow_back</span>
                    Back to Rentals
                </a>
                <div class="flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Rental Details</h1>
                    <button onclick="window.print()"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg flex items-center gap-2 transition-colors">
                        <span class="material-symbols-outlined">print</span>
                        Print Details
                    </button>
                </div>
            </div>

            <!-- Rental Card -->
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden print:shadow-none print:border-none">
                <!-- Header -->
                <div class="p-8 bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="text-2xl font-bold text-blue-600 dark:text-blue-400">RENTAL AGREEMENT</h2>
                            <p class="text-gray-500 dark:text-gray-400 mt-1">
                                #RNT-{{ str_pad($rental->id, 6, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <div class="text-right">
                            <h3 class="font-bold text-gray-900 dark:text-white text-lg">Library Management System</h3>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">123 Library Street</p>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">City, State, ZIP</p>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-8">
                    <!-- Info Grid -->
                    <div class="grid grid-cols-2 gap-8 mb-8">
                        <div>
                            <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Renter Details</h4>
                            <p class="font-bold text-gray-900 dark:text-white text-lg">{{ $rental->user->name }}</p>
                            <p class="text-gray-600 dark:text-gray-400">{{ $rental->user->email }}</p>
                            <p class="text-gray-600 dark:text-gray-400">{{ $rental->user->phone ?? 'No phone' }}</p>
                            <p class="text-gray-600 dark:text-gray-400 max-w-xs">
                                {{ $rental->user->address ?? 'No address provided' }}
                            </p>
                        </div>
                        <div class="text-right">
                            <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Rental Date</h4>
                            <p class="font-bold text-gray-900 dark:text-white text-lg">
                                {{ $rental->rental_date->format('F d, Y') }}
                            </p>

                            <!-- Status Display -->
                            <div class="mt-4">
                                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Status</p>
                                <div class="flex justify-end items-center gap-2">
                                    <span class="px-3 py-1 rounded-full text-sm font-bold uppercase
                                                {{ $rental->status === 'returned' ? 'bg-green-100 text-green-800' :
        ($rental->is_overdue ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') }}">
                                        {{ $rental->status === 'active' && $rental->is_overdue ? 'Overdue' : ucfirst($rental->status) }}
                                    </span>
                                </div>
                                @if($rental->status === 'active' && !$rental->is_overdue)
                                    <p class="text-sm text-gray-500 mt-1">Due:
                                        {{ $rental->expected_return_date->format('M d, Y') }}
                                    </p>
                                @elseif($rental->is_overdue && $rental->status !== 'returned')
                                    <p class="text-sm text-red-600 font-semibold mt-1">
                                        Overdue by {{ $rental->days_overdue }} days
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Items Table -->
                    @if($rental->delivery_name || $rental->delivery_address)
                        @php
                            $isCustomDelivery = ($rental->delivery_name !== $rental->user->name)
                                || ($rental->delivery_phone !== $rental->user->phone)
                                || ($rental->delivery_address !== $rental->user->address);
                        @endphp
                        <div
                            class="mb-8 p-4 rounded-xl {{ $isCustomDelivery ? 'bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700' : 'bg-gray-50 dark:bg-gray-700/30 border border-gray-200 dark:border-gray-600' }}">
                            <div class="flex items-center gap-2 mb-3">
                                <span
                                    class="material-symbols-outlined text-base {{ $isCustomDelivery ? 'text-amber-600' : 'text-gray-500' }}">local_shipping</span>
                                <h4
                                    class="text-xs font-bold {{ $isCustomDelivery ? 'text-amber-700 dark:text-amber-400' : 'text-gray-500' }} uppercase tracking-wider">
                                    Delivery Address
                                    @if($isCustomDelivery)
                                        <span
                                            class="ml-2 px-2 py-0.5 bg-amber-100 text-amber-700 dark:bg-amber-900/50 dark:text-amber-300 rounded-full text-[10px] font-bold">Changed
                                            at checkout</span>
                                    @endif
                                </h4>
                            </div>
                            <p class="font-bold text-gray-900 dark:text-white">
                                {{ $rental->delivery_name ?? $rental->user->name }}</p>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">
                                {{ $rental->delivery_phone ?? $rental->user->phone }}</p>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                                {{ $rental->delivery_address ?? $rental->user->address }}</p>
                        </div>
                    @endif

                    <table class="w-full mb-8">
                        <thead>
                            <tr class="border-b-2 border-gray-200 dark:border-gray-700">
                                <th class="text-left py-3 text-sm font-bold text-gray-600 dark:text-gray-400 uppercase">Book
                                    Details</th>
                                <th class="text-right py-3 text-sm font-bold text-gray-600 dark:text-gray-400 uppercase">
                                    Rental Fee</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-100 dark:border-gray-700/50">
                                <td class="py-4">
                                    <p class="font-bold text-gray-900 dark:text-white">{{ $rental->book->title }}</p>
                                    <p class="text-sm text-gray-500">{{ $rental->book->author }}</p>
                                    <p class="text-xs text-gray-400 mt-1">ISBN: {{ $rental->book->isbn ?? 'N/A' }}</p>
                                </td>
                                <td class="text-right py-4 font-bold text-gray-900 dark:text-white">
                                    ₹{{ number_format($rental->rental_price, 2) }}
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="text-right py-4 text-gray-600 dark:text-gray-400">Subtotal</td>
                                <td class="text-right py-4 font-bold text-gray-900 dark:text-white">
                                    ₹{{ number_format($rental->rental_price, 2) }}
                                </td>
                            </tr>
                            @if($rental->late_fee > 0 || ($rental->is_overdue && $rental->status !== 'returned'))
                                <tr>
                                    <td class="text-right py-2 text-red-600 dark:text-red-400 font-medium">
                                        Late Fee {{ $rental->status !== 'returned' ? '(Estimated)' : '' }}
                                    </td>
                                    <td class="text-right py-2 font-bold text-red-600 dark:text-red-400">
                                        ₹{{ number_format($rental->status === 'returned' ? $rental->late_fee : $rental->calculated_late_fee, 2) }}
                                    </td>
                                </tr>
                            @endif
                            <tr class="border-t-2 border-gray-200 dark:border-gray-700">
                                <td class="text-right py-4 text-lg font-bold text-gray-900 dark:text-white">
                                    Total Amount
                                </td>
                                <td class="text-right py-4 text-lg font-bold text-emerald-600 dark:text-emerald-400">
                                    ₹{{ number_format($rental->status === 'returned' ? $rental->total_amount : ($rental->rental_price + $rental->calculated_late_fee), 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>

                    <!-- Actions -->
                    @if($rental->status !== 'returned')
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6 flex justify-end print:hidden">
                            <form method="POST" action="{{ route('library.admin.rentals.markReturned', $rental) }}"
                                class="flex items-center gap-4">
                                @csrf
                                @method('PATCH')
                                <div class="flex items-center gap-2">
                                    <label for="return_date" class="text-sm text-gray-600 dark:text-gray-400">Return
                                        Date:</label>
                                    <input type="date" name="return_date" id="return_date" value="{{ date('Y-m-d') }}"
                                        max="{{ date('Y-m-d') }}"
                                        class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <button type="submit"
                                    onclick="return confirm('Are you sure you want to mark this rental as returned?')"
                                    class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl shadow-lg transition-all duration-200 flex items-center gap-2">
                                    <span class="material-symbols-outlined">check_circle</span>
                                    Mark as Returned
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                            <div
                                class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4 flex items-center gap-3 text-green-800 dark:text-green-300">
                                <span class="material-symbols-outlined text-2xl">task_alt</span>
                                <div>
                                    <p class="font-bold">Rental Returned</p>
                                    <p class="text-sm">Returned on {{ $rental->actual_return_date->format('F d, Y') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Footer -->
                <div
                    class="bg-gray-50 dark:bg-gray-700/50 p-6 text-center text-sm text-gray-500 dark:text-gray-400 border-t border-gray-200 dark:border-gray-700">
                    <p>Terms and conditions apply. Please return books on time to avoid late fees.</p>
                </div>
            </div>
        </div>
    </div>
@endsection