@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8 relative overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 p-8 shadow-2xl">
                <div class="absolute inset-0 bg-black/10"></div>
                <div class="relative z-10 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="p-4 bg-white/20 backdrop-blur-sm rounded-full">
                            <span class="material-symbols-outlined text-5xl text-white">inventory</span>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-white mb-1">Donation Status Tracking</h1>
                            <p class="text-white/90">Monitor all approved and rejected book donations</p>
                        </div>
                    </div>
                    <a href="{{ route('library.admin.index') }}" class="px-4 py-2 bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white rounded-lg transition-all duration-200 flex items-center gap-2">
                        <span class="material-symbols-outlined">arrow_back</span>
                        Dashboard
                    </a>
                </div>
            </div>

            @if($donations->isEmpty())
                <!-- Empty State -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-12 text-center">
                    <span class="material-symbols-outlined text-6xl text-gray-400 mb-4">inventory_2</span>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No Processed Donations</h3>
                    <p class="text-gray-600 dark:text-gray-400">No donations have been approved or rejected yet.</p>
                </div>
            @else
                <!-- Donations Table -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Book Details</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Donor Info</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Approval Details</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Current Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($donations as $donation)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                        <!-- Book Details -->
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-4">
                                                @if($donation->cover_image)
                                                    <img src="{{ asset('storage/' . $donation->cover_image) }}" alt="{{ $donation->title }}" class="w-16 h-20 object-cover rounded shadow-sm">
                                                @else
                                                    <div class="w-16 h-20 bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-700 dark:to-gray-600 rounded flex items-center justify-center">
                                                        <span class="material-symbols-outlined text-2xl text-gray-400">book</span>
                                                    </div>
                                                @endif
                                                <div>
                                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $donation->title }}</p>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">by {{ $donation->author }}</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">{{ $donation->category }}</p>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Donor Info -->
                                        <td class="px-6 py-4">
                                            <div class="space-y-1">
                                                <div class="flex items-center gap-2 text-sm">
                                                    <span class="material-symbols-outlined text-sm text-gray-500">person</span>
                                                    <span class="text-gray-900 dark:text-white font-medium">{{ $donation->donor->name ?? 'Unknown' }}</span>
                                                </div>
                                                @if($donation->donor_location)
                                                    <div class="flex items-center gap-2 text-xs text-gray-600 dark:text-gray-400">
                                                        <span class="material-symbols-outlined text-xs">location_on</span>
                                                        <span>{{ $donation->donor_location }}</span>
                                                    </div>
                                                @endif
                                                <div class="flex items-center gap-2 text-xs text-gray-600 dark:text-gray-400">
                                                    <span class="material-symbols-outlined text-xs">calendar_today</span>
                                                    <span>Donated: {{ $donation->created_at->format('M d, Y') }}</span>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Approval Details -->
                                        <td class="px-6 py-4">
                                            @if($donation->status === 'available')
                                                <div class="space-y-1">
                                                    <div class="flex items-center gap-2 text-sm text-green-600 dark:text-green-400">
                                                        <span class="material-symbols-outlined text-sm">check_circle</span>
                                                        <span class="font-semibold">Approved</span>
                                                    </div>
                                                    @if($donation->approver)
                                                        <div class="flex items-center gap-2 text-xs text-gray-600 dark:text-gray-400">
                                                            <span class="material-symbols-outlined text-xs">person</span>
                                                            <span>By: {{ $donation->approver->name }}</span>
                                                        </div>
                                                    @endif
                                                    @if($donation->approved_at)
                                                        <div class="flex items-center gap-2 text-xs text-gray-600 dark:text-gray-400">
                                                            <span class="material-symbols-outlined text-xs">schedule</span>
                                                            <span>{{ $donation->approved_at->format('M d, Y h:i A') }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            @elseif($donation->status === 'rejected')
                                                <div class="space-y-1">
                                                    <div class="flex items-center gap-2 text-sm text-red-600 dark:text-red-400">
                                                        <span class="material-symbols-outlined text-sm">cancel</span>
                                                        <span class="font-semibold">Rejected</span>
                                                    </div>
                                                    @if($donation->rejected_at)
                                                        <div class="flex items-center gap-2 text-xs text-gray-600 dark:text-gray-400">
                                                            <span class="material-symbols-outlined text-xs">schedule</span>
                                                            <span>{{ $donation->rejected_at->format('M d, Y h:i A') }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                        </td>

                                        <!-- Current Status -->
                                        <td class="px-6 py-4">
                                            @if($donation->status === 'available')
                                                <div class="space-y-2">
                                                    <!-- Availability Type -->
                                                    <div>
                                                        @if($donation->type === 'rent')
                                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                                                <span class="material-symbols-outlined text-xs mr-1">schedule</span>
                                                                For Rent
                                                            </span>
                                                        @elseif($donation->type === 'sale')
                                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                                                <span class="material-symbols-outlined text-xs mr-1">sell</span>
                                                                For Sale
                                                            </span>
                                                        @elseif($donation->type === 'both')
                                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300">
                                                                <span class="material-symbols-outlined text-xs mr-1">swap_horiz</span>
                                                                Rent/Sale
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <!-- Pricing -->
                                                    <div class="text-xs text-gray-600 dark:text-gray-400">
                                                        @if($donation->rental_price > 0)
                                                            <div>Rent: ₹{{ number_format($donation->rental_price, 2) }}</div>
                                                        @endif
                                                        @if($donation->selling_price > 0)
                                                            <div>Sale: ₹{{ number_format($donation->selling_price, 2) }}</div>
                                                        @endif
                                                    </div>

                                                    <!-- Stock Status -->
                                                    <div class="text-xs">
                                                        @if($donation->quantity > 0)
                                                            <span class="text-green-600 dark:text-green-400 font-medium">In Stock ({{ $donation->quantity }})</span>
                                                        @else
                                                            <span class="text-red-600 dark:text-red-400 font-medium">Out of Stock</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-sm text-gray-500 dark:text-gray-400">Not Available</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $donations->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
