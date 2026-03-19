@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8 print:hidden">
                <a href="{{ route('library.admin.sales.index') }}"
                    class="inline-flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white mb-4">
                    <span class="material-symbols-outlined">arrow_back</span>
                    Back to Sales
                </a>
                <div class="flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Sale Details</h1>
                    <button onclick="window.print()"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg flex items-center gap-2 transition-colors">
                        <span class="material-symbols-outlined">print</span>
                        Print Invoice
                    </button>
                </div>
            </div>

            <!-- Invoice Card -->
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden print:shadow-none print:border-none">
                <!-- Invoice Header -->
                <div class="p-8 bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">INVOICE</h2>
                            <p class="text-gray-500 dark:text-gray-400 mt-1">
                                #INV-{{ str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <div class="text-right">
                            <h3 class="font-bold text-gray-900 dark:text-white text-lg">Library Management System</h3>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">123 Library Street</p>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">City, State, ZIP</p>
                        </div>
                    </div>
                </div>

                <!-- Invoice Content -->
                <div class="p-8">
                    <!-- Info Grid -->
                    <div class="grid grid-cols-2 gap-8 mb-8">
                        <!-- Billed To -->
                        <div>
                            <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Billed To</h4>
                            <p class="font-bold text-gray-900 dark:text-white text-lg">{{ $sale->user->name }}</p>
                            <p class="text-gray-600 dark:text-gray-400">{{ $sale->user->email }}</p>
                            <p class="text-gray-600 dark:text-gray-400">{{ $sale->user->phone ?? 'No phone' }}</p>
                            <p class="text-gray-600 dark:text-gray-400 max-w-xs">
                                {{ $sale->user->address ?? 'No address provided' }}</p>
                        </div>
                        <div class="text-right">
                            <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Sale Date</h4>
                            <p class="font-bold text-gray-900 dark:text-white text-lg">
                                {{ $sale->sale_date->format('F d, Y') }}
                            </p>

                            <!-- Payment Status Update -->
                            <div class="mt-4">
                                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Payment Status</p>
                                <form action="{{ route('library.admin.sales.updateStatus', $sale) }}" method="POST"
                                    class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="type" value="payment">
                                    <select name="status" onchange="this.form.submit()"
                                        class="text-xs rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 py-1 pr-8">
                                        <option value="pending" {{ $sale->payment_status === 'pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="completed" {{ $sale->payment_status === 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="refunded" {{ $sale->payment_status === 'refunded' ? 'selected' : '' }}>
                                            Refunded</option>
                                    </select>
                                    <span
                                        class="px-2 py-1 rounded-full text-xs font-bold uppercase
                                            {{ $sale->payment_status === 'completed' ? 'bg-green-100 text-green-800' :
        ($sale->payment_status === 'refunded' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ $sale->payment_status }}
                                    </span>
                                </form>
                            </div>

                            <!-- Delivery Status Update -->
                            <div class="mt-4">
                                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Delivery Status</p>
                                <form action="{{ route('library.admin.sales.updateStatus', $sale) }}" method="POST"
                                    class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="type" value="delivery">
                                    <select name="status" onchange="this.form.submit()"
                                        class="text-xs rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 py-1 pr-8">
                                        <option value="pending" {{ $sale->delivery_status === 'pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="dispatched" {{ $sale->delivery_status === 'dispatched' ? 'selected' : '' }}>Dispatched</option>
                                        <option value="on_the_way" {{ $sale->delivery_status === 'on_the_way' ? 'selected' : '' }}>On the Way</option>
                                        <option value="delivered" {{ $sale->delivery_status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                        <option value="cancelled" {{ $sale->delivery_status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                    <span
                                        class="px-2 py-1 rounded-full text-xs font-bold uppercase
                                            {{ $sale->delivery_status === 'delivered' ? 'bg-green-100 text-green-800' :
        ($sale->delivery_status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') }}">
                                        {{ str_replace('_', ' ', $sale->delivery_status) }}
                                    </span>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Delivery Address Card --}}
                    @if($sale->delivery_name || $sale->delivery_address)
                        @php
                            $isCustomDelivery = ($sale->delivery_name !== $sale->user->name)
                                || ($sale->delivery_phone !== $sale->user->phone)
                                || ($sale->delivery_address !== $sale->user->address);
                        @endphp
                        <div class="mb-8 p-4 rounded-xl {{ $isCustomDelivery ? 'bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700' : 'bg-gray-50 dark:bg-gray-700/30 border border-gray-200 dark:border-gray-600' }}">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="material-symbols-outlined text-base {{ $isCustomDelivery ? 'text-amber-600' : 'text-gray-500' }}">local_shipping</span>
                                <h4 class="text-xs font-bold {{ $isCustomDelivery ? 'text-amber-700 dark:text-amber-400' : 'text-gray-500' }} uppercase tracking-wider">
                                    Delivery Address
                                    @if($isCustomDelivery)
                                        <span class="ml-2 px-2 py-0.5 bg-amber-100 text-amber-700 dark:bg-amber-900/50 dark:text-amber-300 rounded-full text-[10px] font-bold">Changed at checkout</span>
                                    @endif
                                </h4>
                            </div>
                            <p class="font-bold text-gray-900 dark:text-white">{{ $sale->delivery_name ?? $sale->user->name }}</p>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $sale->delivery_phone ?? $sale->user->phone }}</p>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">{{ $sale->delivery_address ?? $sale->user->address }}</p>
                        </div>
                    @endif

                    <!-- Items Table -->
                    <table class="w-full mb-8">
                        <thead>
                            <tr class="border-b-2 border-gray-200 dark:border-gray-700">
                                <th class="text-left py-3 text-sm font-bold text-gray-600 dark:text-gray-400 uppercase">Item
                                </th>
                                <th class="text-center py-3 text-sm font-bold text-gray-600 dark:text-gray-400 uppercase">
                                    Qty</th>
                                <th class="text-right py-3 text-sm font-bold text-gray-600 dark:text-gray-400 uppercase">
                                    Price</th>
                                <th class="text-right py-3 text-sm font-bold text-gray-600 dark:text-gray-400 uppercase">
                                    Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-100 dark:border-gray-700/50">
                                <td class="py-4">
                                    <p class="font-bold text-gray-900 dark:text-white">{{ $sale->book->title }}</p>
                                    <p class="text-sm text-gray-500">{{ $sale->book->author }}</p>
                                </td>
                                <td class="text-center py-4 text-gray-900 dark:text-white">{{ $sale->quantity }}</td>
                                <td class="text-right py-4 text-gray-900 dark:text-white">
                                    ₹{{ number_format($sale->price_per_unit, 2) }}</td>
                                <td class="text-right py-4 font-bold text-gray-900 dark:text-white">
                                    ₹{{ number_format($sale->total_amount, 2) }}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-right py-4 text-gray-600 dark:text-gray-400">Subtotal</td>
                                <td class="text-right py-4 font-bold text-gray-900 dark:text-white">
                                    ₹{{ number_format($sale->total_amount, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right py-2 text-gray-600 dark:text-gray-400">Tax (0%)</td>
                                <td class="text-right py-2 font-bold text-gray-900 dark:text-white">₹0.00</td>
                            </tr>
                            <tr class="border-t-2 border-gray-200 dark:border-gray-700">
                                <td colspan="3" class="text-right py-4 text-lg font-bold text-gray-900 dark:text-white">
                                    Total</td>
                                <td class="text-right py-4 text-lg font-bold text-emerald-600 dark:text-emerald-400">
                                    ₹{{ number_format($sale->total_amount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>

                    @if($sale->payment_method)
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                            <p class="text-sm text-gray-600 dark:text-gray-400">Payment Method: <span
                                    class="font-semibold text-gray-900 dark:text-white uppercase">{{ $sale->payment_method }}</span>
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Footer -->
                <div
                    class="bg-gray-50 dark:bg-gray-700/50 p-6 text-center text-sm text-gray-500 dark:text-gray-400 border-t border-gray-200 dark:border-gray-700">
                    <p>Thank you for your purchase!</p>
                </div>
            </div>
        </div>
    </div>
@endsection