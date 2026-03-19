@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8 relative overflow-hidden rounded-2xl bg-gradient-to-r from-red-600 via-orange-600 to-yellow-600 p-8 shadow-2xl">
                <div class="absolute inset-0 bg-black/10"></div>
                <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="p-4 bg-white/20 backdrop-blur-sm rounded-full">
                            <span class="material-symbols-outlined text-5xl text-white">bar_chart</span>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-white mb-1">Reports & Analytics</h1>
                            <p class="text-white/90">Detailed insights into your library's performance</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('library.admin.reports.export', ['type' => 'sales', 'start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl shadow-lg transition-colors flex items-center gap-2">
                            <span class="material-symbols-outlined">table_view</span>
                            Export Sales
                        </a>
                        <a href="{{ route('library.admin.reports.export', ['type' => 'rentals', 'start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-lg transition-colors flex items-center gap-2">
                            <span class="material-symbols-outlined">table_view</span>
                            Export Rentals
                        </a>
                        <button onclick="window.print()" class="px-4 py-2 bg-white hover:bg-gray-100 text-red-600 font-semibold rounded-xl shadow-lg transition-colors flex items-center gap-2">
                            <span class="material-symbols-outlined">print</span>
                            Print
                        </button>
                    </div>
                </div>
            </div>

            <!-- Date Filter -->
            <div class="mb-8 bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                <form action="{{ route('library.admin.reports.index') }}" method="GET" class="flex flex-col md:flex-row items-end gap-4">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">From Date</label>
                        <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:ring-orange-500 focus:border-orange-500 block w-full shadow-sm sm:text-sm">
                    </div>
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">To Date</label>
                        <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:ring-orange-500 focus:border-orange-500 block w-full shadow-sm sm:text-sm">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white font-medium rounded-lg shadow transition-colors flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">filter_list</span>
                            Filter
                        </button>
                        @if(request('start_date') || request('end_date'))
                            <a href="{{ route('library.admin.reports.index') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-medium rounded-lg shadow transition-colors flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">close</span>
                                Clear
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Revenue -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-xl">
                            <span class="material-symbols-outlined text-3xl text-green-600 dark:text-green-400">payments</span>
                        </div>
                        <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Total Revenue</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">₹{{ number_format($totalRevenue, 2) }}</h3>
                    <p class="text-sm text-green-600 dark:text-green-400 font-medium">Sales: ₹{{ number_format($totalSalesRevenue, 2) }} | Rentals: ₹{{ number_format($totalRentalRevenue, 2) }}</p>
                </div>

                <!-- Active Rentals -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-xl">
                            <span class="material-symbols-outlined text-3xl text-blue-600 dark:text-blue-400">key</span>
                        </div>
                        <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Active Rentals</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">{{ $activeRentalsCount }}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Currently rented books</p>
                </div>

                <!-- Overdue Rentals -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-red-100 dark:bg-red-900/30 rounded-xl">
                            <span class="material-symbols-outlined text-3xl text-red-600 dark:text-red-400">warning</span>
                        </div>
                        <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Overdue Rentals</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">{{ $overdueRentalsCount }}</h3>
                    <p class="text-sm text-red-600 dark:text-red-400 font-medium">Require attention</p>
                </div>

                <!-- Books Sold -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-purple-100 dark:bg-purple-900/30 rounded-xl">
                            <span class="material-symbols-outlined text-3xl text-purple-600 dark:text-purple-400">shopping_bag</span>
                        </div>
                        <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Books Sold</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">{{ $booksSold }}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Total units sold</p>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Revenue Chart -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Revenue Overview (Last 6 Months)</h3>
                    <canvas id="revenueChart" style="max-height: 300px;"></canvas>
                </div>

                <!-- Rental Distribution -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Rental Status Distribution</h3>
                    <div class="flex justify-center">
                        <div style="max-width: 300px; width: 100%;">
                            <canvas id="rentalChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Recent Sales -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Recent Sales</h3>
                    </div>
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($recentSales as $sale)
                            <div class="p-4 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-lg">
                                        <span class="material-symbols-outlined text-green-600 dark:text-green-400">point_of_sale</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $sale->book->title }}</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Sold to {{ $sale->user->name }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-gray-900 dark:text-white">₹{{ number_format($sale->total_amount, 2) }}</p>
                                    <p class="text-xs text-gray-500">{{ $sale->sale_date->format('M d') }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                                No recent sales found.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Rentals -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Recent Rentals</h3>
                    </div>
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($recentRentals as $rental)
                            <div class="p-4 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                                        <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">key</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $rental->book->title }}</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Rented by {{ $rental->user->name }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    @if($rental->status == 'active')
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-bold">Active</span>
                                    @elseif($rental->status == 'returned')
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-bold">Returned</span>
                                    @endif
                                    <p class="text-xs text-gray-500 mt-1">{{ $rental->rental_date->format('M d') }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                                No recent rentals found.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Revenue Chart
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            new Chart(revenueCtx, {
                type: 'bar',
                data: {
                    labels: @json($months),
                    datasets: [
                        {
                            label: 'Sales Revenue',
                            data: @json($salesData),
                            backgroundColor: 'rgba(34, 197, 94, 0.6)',
                            borderColor: 'rgb(34, 197, 94)',
                            borderWidth: 1
                        },
                        {
                            label: 'Rental Revenue',
                            data: @json($rentalData),
                            backgroundColor: 'rgba(59, 130, 246, 0.6)',
                            borderColor: 'rgb(59, 130, 246)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            // Rental Status Chart
            const rentalCtx = document.getElementById('rentalChart').getContext('2d');
            new Chart(rentalCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Active (On Time)', 'Overdue', 'Returned'],
                    datasets: [{
                        data: @json($rentalStatusData),
                        backgroundColor: [
                            'rgb(59, 130, 246)',
                            'rgb(239, 68, 68)',
                            'rgb(34, 197, 94)'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        });
    </script>
@endsection
