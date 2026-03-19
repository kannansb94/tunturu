@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Header -->
            <div
                class="mb-8 relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 p-8 shadow-2xl">
                <div class="absolute inset-0 bg-black/10"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="p-3 bg-white/20 backdrop-blur-sm rounded-xl">
                            <span class="material-symbols-outlined text-4xl">dashboard</span>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold">{{ auth()->user()->role_relation->name ?? 'Admin' }} Dashboard
                            </h1>
                            <p class="text-blue-100">Welcome back, {{ auth()->user()->name }}!</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Books -->
                @if(auth()->user()->can('manage_books') || auth()->user()->can('manage_rentals') || auth()->user()->can('manage_sales'))
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 hover:shadow-xl transition-all">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-xl">
                                <span
                                    class="material-symbols-outlined text-3xl text-blue-600 dark:text-blue-400">library_books</span>
                            </div>
                            <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Total</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">{{ \App\Models\Book::count() }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Books in Library</p>
                    </div>
                @endif

                <!-- Available Books -->
                @if(auth()->user()->can('manage_books') || auth()->user()->can('manage_rentals') || auth()->user()->can('manage_sales'))
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 hover:shadow-xl transition-all">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-xl">
                                <span
                                    class="material-symbols-outlined text-3xl text-green-600 dark:text-green-400">check_circle</span>
                            </div>
                            <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Available</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">
                            {{ \App\Models\Book::where('status', 'available')->count() }}
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Ready to Rent/Sell</p>
                    </div>
                @endif

                <!-- Active Rentals -->
                @if(auth()->user()->can('manage_rentals'))
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 hover:shadow-xl transition-all">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-yellow-100 dark:bg-yellow-900/30 rounded-xl">
                                <span
                                    class="material-symbols-outlined text-3xl text-yellow-600 dark:text-yellow-400">schedule</span>
                            </div>
                            <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Active</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">
                            {{ \App\Models\Rental::where('status', 'active')->count() }}
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Current Rentals</p>
                    </div>
                @endif

                <!-- Total Users -->
                @if(auth()->user()->can('manage_users'))
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 hover:shadow-xl transition-all">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-purple-100 dark:bg-purple-900/30 rounded-xl">
                                <span
                                    class="material-symbols-outlined text-3xl text-purple-600 dark:text-purple-400">group</span>
                            </div>
                            <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Users</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">
                            {{ \App\Models\User::where('role', 'user')->count() }}
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Registered Members</p>
                    </div>
                @endif
            </div>

            <!-- Quick Actions -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-purple-600">bolt</span>
                    Quick Actions
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @if(auth()->user()->hasPermission('manage_books'))
                        <a href="{{ route('library.admin.books.create') }}"
                            class="bg-gradient-to-br from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-2xl shadow-lg p-6 transition-all transform hover:scale-105">
                            <div class="flex items-center gap-4">
                                <div class="p-3 bg-white/20 backdrop-blur-sm rounded-xl">
                                    <span class="material-symbols-outlined text-3xl">add</span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold">Add New Book</h3>
                                    <p class="text-sm text-white/80">Expand your collection</p>
                                </div>
                            </div>
                        </a>
                    @endif



                    @if(auth()->user()->hasPermission('manage_users'))
                        <a href="{{ route('library.admin.users.index') }}"
                            class="bg-gradient-to-br from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white rounded-2xl shadow-lg p-6 transition-all transform hover:scale-105">
                            <div class="flex items-center gap-4">
                                <div class="p-3 bg-white/20 backdrop-blur-sm rounded-xl">
                                    <span class="material-symbols-outlined text-3xl">verified_user</span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold">Verify KYC</h3>
                                    <p class="text-sm text-white/80">Approve user accounts</p>
                                </div>
                            </div>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Management Modules -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-purple-600">apps</span>
                    Management Modules
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Inventory -->
                    @if(auth()->user()->hasPermission('manage_books'))
                        <a href="{{ route('library.admin.books.index') }}"
                            class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 hover:shadow-xl transition-all group">
                            <div class="flex items-center gap-4 mb-4">
                                <div
                                    class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-xl group-hover:scale-110 transition-transform">
                                    <span
                                        class="material-symbols-outlined text-3xl text-blue-600 dark:text-blue-400">inventory_2</span>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Book Inventory</h3>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Manage your book collection, add new titles, and
                                update stock levels</p>
                        </a>
                    @endif

                    <!-- Users & KYC -->
                    @if(auth()->user()->hasPermission('manage_users'))
                        <a href="{{ route('library.admin.users.index') }}"
                            class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 hover:shadow-xl transition-all group">
                            <div class="flex items-center gap-4 mb-4">
                                <div
                                    class="p-3 bg-purple-100 dark:bg-purple-900/30 rounded-xl group-hover:scale-110 transition-transform">
                                    <span
                                        class="material-symbols-outlined text-3xl text-purple-600 dark:text-purple-400">group</span>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Users & KYC</h3>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Manage user accounts and verify KYC documents
                                for approval</p>
                        </a>
                    @endif

                    <!-- Rentals -->
                    @if(auth()->user()->hasPermission('manage_rentals'))
                        @php
                            $lastViewedRentals = auth()->user()->last_viewed_rentals_at;
                            $pendingRentalsQuery = \App\Models\Rental::whereIn('status', ['active']);
                            if ($lastViewedRentals) {
                                $pendingRentalsQuery->where('created_at', '>', $lastViewedRentals);
                            }
                            $pendingRentals = $pendingRentalsQuery->count();
                        @endphp
                        <a href="{{ route('library.admin.rentals.index') }}"
                            class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 hover:shadow-xl transition-all group relative">
                            @if($pendingRentals > 0)
                                <span
                                    class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded-full shadow-lg border-2 border-white dark:border-gray-800 z-10 animate-bounce">
                                    {{ $pendingRentals }} {{ $pendingRentals === 1 ? 'New' : 'New' }}
                                </span>
                            @endif
                            <div class="flex items-center gap-4 mb-4">
                                <div
                                    class="p-3 bg-yellow-100 dark:bg-yellow-900/30 rounded-xl group-hover:scale-110 transition-transform">
                                    <span
                                        class="material-symbols-outlined text-3xl text-yellow-600 dark:text-yellow-400">key</span>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Rental Management</h3>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Track active rentals, returns, and manage late
                                fees</p>
                        </a>
                    @endif

                    <!-- Sales -->
                    @if(auth()->user()->hasPermission('manage_sales'))
                        @php
                            $lastViewedSales = auth()->user()->last_viewed_sales_at;
                            $pendingSalesQuery = \App\Models\Sale::where('delivery_status', 'pending');
                            if ($lastViewedSales) {
                                $pendingSalesQuery->where('created_at', '>', $lastViewedSales);
                            }
                            $pendingSales = $pendingSalesQuery->count();
                        @endphp
                        <a href="{{ route('library.admin.sales.index') }}"
                            class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 hover:shadow-xl transition-all group relative">
                            @if($pendingSales > 0)
                                <span
                                    class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded-full shadow-lg border-2 border-white dark:border-gray-800 z-10 animate-bounce">
                                    {{ $pendingSales }} {{ $pendingSales === 1 ? 'New' : 'New' }}
                                </span>
                            @endif
                            <div class="flex items-center gap-4 mb-4">
                                <div
                                    class="p-3 bg-green-100 dark:bg-green-900/30 rounded-xl group-hover:scale-110 transition-transform">
                                    <span
                                        class="material-symbols-outlined text-3xl text-green-600 dark:text-green-400">point_of_sale</span>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Sales Management</h3>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Oversee book sales and transaction history</p>
                        </a>
                    @endif

                    <!-- Donations -->
                    @if(auth()->user()->hasPermission('manage_donations'))
                        <a href="{{ route('library.admin.donations.index') }}"
                            class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 hover:shadow-xl transition-all group">
                            <div class="flex items-center gap-4 mb-4">
                                <div
                                    class="p-3 bg-pink-100 dark:bg-pink-900/30 rounded-xl group-hover:scale-110 transition-transform">
                                    <span
                                        class="material-symbols-outlined text-3xl text-pink-600 dark:text-pink-400">volunteer_activism</span>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Book Donations</h3>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Review and approve pending book donations from
                                users</p>
                        </a>
                    @endif

                    <!-- Categories -->
                    @if(auth()->user()->hasPermission('manage_categories'))
                        <a href="{{ route('library.admin.categories.index') }}"
                            class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 hover:shadow-xl transition-all group">
                            <div class="flex items-center gap-4 mb-4">
                                <div
                                    class="p-3 bg-indigo-100 dark:bg-indigo-900/30 rounded-xl group-hover:scale-110 transition-transform">
                                    <span
                                        class="material-symbols-outlined text-3xl text-indigo-600 dark:text-indigo-400">category</span>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Categories</h3>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Create and manage book categories for
                                organization</p>
                        </a>
                    @endif

                    <!-- Bulk Upload -->
                    @if(auth()->user()->hasPermission('manage_books'))
                        <a href="{{ route('library.admin.bulk.index') }}"
                            class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 hover:shadow-xl transition-all group">
                            <div class="flex items-center gap-4 mb-4">
                                <div
                                    class="p-3 bg-orange-100 dark:bg-orange-900/30 rounded-xl group-hover:scale-110 transition-transform">
                                    <span
                                        class="material-symbols-outlined text-3xl text-orange-600 dark:text-orange-400">cloud_upload</span>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Bulk Upload</h3>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Import multiple books at once via Excel or CSV
                                files</p>
                        </a>
                    @endif

                    <!-- Reports -->
                    @if(auth()->user()->hasPermission('view_reports'))
                        <a href="{{ route('library.admin.reports.index') }}"
                            class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 hover:shadow-xl transition-all group">
                            <div class="flex items-center gap-4 mb-4">
                                <div
                                    class="p-3 bg-red-100 dark:bg-red-900/30 rounded-xl group-hover:scale-110 transition-transform">
                                    <span
                                        class="material-symbols-outlined text-3xl text-red-600 dark:text-red-400">bar_chart</span>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Reports & Analytics</h3>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">View detailed insights on rentals, sales, and
                                revenue</p>
                        </a>
                    @endif

                    <!-- Settings -->
                    @if(auth()->user()->hasPermission('manage_settings'))
                        <a href="{{ route('library.admin.settings.index') }}"
                            class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 hover:shadow-xl transition-all group">
                            <div class="flex items-center gap-4 mb-4">
                                <div
                                    class="p-3 bg-gray-100 dark:bg-gray-700 rounded-xl group-hover:scale-110 transition-transform">
                                    <span
                                        class="material-symbols-outlined text-3xl text-gray-600 dark:text-gray-400">settings</span>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">System Settings</h3>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Configure rental rules, late fees, and system
                                preferences</p>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection