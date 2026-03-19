<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Library') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-surface-dark p-6 rounded-lg text-white border border-white/10">
                    <div class="flex items-center gap-4">
                        <span class="material-symbols-outlined text-4xl text-primary">book</span>
                        <div>
                            <h3 class="text-lg font-bold">Active Rentals</h3>
                            <p class="text-3xl font-black">{{ $rentals->where('status', 'active')->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-surface-dark p-6 rounded-lg text-white border border-white/10">
                    <div class="flex items-center gap-4">
                        <span class="material-symbols-outlined text-4xl text-primary">volunteer_activism</span>
                        <div>
                            <h3 class="text-lg font-bold">My Donations</h3>
                            <p class="text-3xl font-black">{{ $donations->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6">
                <a href="{{ route('profile.edit') }}"
                    class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow hover:shadow-lg transition-all border border-gray-200 dark:border-gray-700 flex flex-col items-center text-center group">
                    <span
                        class="material-symbols-outlined text-4xl text-purple-500 mb-4 group-hover:scale-110 transition-transform">account_circle</span>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">My Profile</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Update profile & KYC</p>
                    @if(Auth::user()->kyc_status === 'approved')
                        <span class="mt-2 px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Verified</span>
                    @elseif(Auth::user()->kyc_status === 'pending')
                        <span class="mt-2 px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Pending</span>
                    @else
                        <span class="mt-2 px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded-full">Not Verified</span>
                    @endif
                </a>
                <a href="{{ route('library.index') }}"
                    class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow hover:shadow-lg transition-all border border-gray-200 dark:border-gray-700 flex flex-col items-center text-center group">
                    <span
                        class="material-symbols-outlined text-4xl text-primary mb-4 group-hover:scale-110 transition-transform">search</span>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Browse Catalog</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Find books to rent or buy.</p>
                </a>
                <a href="{{ route('library.user.donate') }}"
                    class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow hover:shadow-lg transition-all border border-gray-200 dark:border-gray-700 flex flex-col items-center text-center group">
                    <span
                        class="material-symbols-outlined text-4xl text-green-500 mb-4 group-hover:scale-110 transition-transform">volunteer_activism</span>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Donate a Book</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Contribute to the reading community.</p>
                </a>
                <a href="{{ route('library.user.donation.status') }}"
                    class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow hover:shadow-lg transition-all border border-gray-200 dark:border-gray-700 flex flex-col items-center text-center group">
                    <span
                        class="material-symbols-outlined text-4xl text-blue-500 mb-4 group-hover:scale-110 transition-transform">book_online</span>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Donation Status</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Track your donated books.</p>
                </a>
                <a href="{{ route('library.user.orders') }}"
                    class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow hover:shadow-lg transition-all border border-gray-200 dark:border-gray-700 flex flex-col items-center text-center group">
                    <span
                        class="material-symbols-outlined text-4xl text-orange-500 mb-4 group-hover:scale-110 transition-transform">local_shipping</span>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Track Orders</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">View status of your purchases.</p>
                </a>
                <a href="{{ route('library.user.rentals') }}"
                    class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow hover:shadow-lg transition-all border border-gray-200 dark:border-gray-700 flex flex-col items-center text-center group">
                    <span
                        class="material-symbols-outlined text-4xl text-teal-500 mb-4 group-hover:scale-110 transition-transform">timeline</span>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Track Rentals</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">View status of your rented books.</p>
                </a>
            </div>

            <!-- My Rentals Section -->
            <div class="mt-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">My Rentals</h2>
                @if($rentals->isEmpty())
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                        <p class="text-gray-600 dark:text-gray-400">You have no active rentals.</p>
                    </div>
                @else
                    <!-- Desktop Table -->
                    <div class="hidden md:block bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Book</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Rented On</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Due Date</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Account Status</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Delivery Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($rentals as $rental)
                                    <tr>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $rental->book->title }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $rental->rental_date->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $rental->expected_return_date->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $rental->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ ucfirst($rental->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @php
                                                $deliveryStatusColors = [
                                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                                    'dispatched' => 'bg-blue-100 text-blue-800',
                                                    'on_the_way' => 'bg-indigo-100 text-indigo-800',
                                                    'delivered' => 'bg-green-100 text-green-800',
                                                    'cancelled' => 'bg-red-100 text-red-800',
                                                ];
                                                $dStatus = $rental->delivery_status ?? 'pending';
                                                $dColor = $deliveryStatusColors[$dStatus] ?? 'bg-gray-100 text-gray-800';
                                            @endphp
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $dColor }}">
                                                {{ ucwords(str_replace('_', ' ', $dStatus)) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Cards -->
                    <div class="md:hidden space-y-4">
                        @foreach($rentals as $rental)
                            <div
                                class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow border border-gray-200 dark:border-gray-700">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="font-bold text-gray-900 dark:text-white">{{ $rental->book->title }}</h3>
                                    <div class="flex flex-col items-end gap-1">
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full {{ $rental->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($rental->status) }}
                                        </span>
                                        @php
                                            $dStatusMobile = $rental->delivery_status ?? 'pending';
                                            $dColorMobile = [
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'dispatched' => 'bg-blue-100 text-blue-800',
                                                'on_the_way' => 'bg-indigo-100 text-indigo-800',
                                                'delivered' => 'bg-green-100 text-green-800',
                                                'cancelled' => 'bg-red-100 text-red-800',
                                            ][$dStatusMobile] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $dColorMobile }}">
                                            {{ ucwords(str_replace('_', ' ', $dStatusMobile)) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex justify-between text-sm text-gray-500 dark:text-gray-400 mt-2">
                                    <span>Due: {{ $rental->expected_return_date->format('M d') }}</span>
                                    <span>Rented: {{ $rental->rental_date->format('M d') }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- My Purchases Section -->
            <div class="mt-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">My Purchases</h2>
                @if($purchases->isEmpty())
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                        <p class="text-gray-600 dark:text-gray-400">You have not purchased any books yet.</p>
                    </div>
                @else
                    <!-- Desktop Table -->
                    <div class="hidden md:block bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Book</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Date</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Amount</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Payment</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Delivery Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($purchases as $sale)
                                    <tr>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $sale->book->title }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $sale->sale_date->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            ₹{{ number_format($sale->total_amount, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ ucfirst($sale->payment_status ?? 'paid') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @php
                                                $statusColors = [
                                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                                    'dispatched' => 'bg-blue-100 text-blue-800',
                                                    'on_the_way' => 'bg-indigo-100 text-indigo-800',
                                                    'delivered' => 'bg-green-100 text-green-800',
                                                    'cancelled' => 'bg-red-100 text-red-800',
                                                ];
                                                $status = $sale->delivery_status ?? 'pending';
                                                $color = $statusColors[$status] ?? 'bg-gray-100 text-gray-800';
                                            @endphp
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color }}">
                                                {{ ucwords(str_replace('_', ' ', $status)) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Cards -->
                    <div class="md:hidden space-y-4">
                        @foreach($purchases as $sale)
                            <div
                                class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow border border-gray-200 dark:border-gray-700">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="font-bold text-gray-900 dark:text-white">{{ $sale->book->title }}</h3>
                                    <span
                                        class="font-bold text-gray-900 dark:text-white">₹{{ number_format($sale->total_amount, 0) }}</span>
                                </div>
                                <div class="flex justify-between items-center mt-2">
                                    <span
                                        class="text-xs text-gray-500 dark:text-gray-400">{{ $sale->sale_date->format('M d, Y') }}</span>
                                    @php
                                        $status = $sale->delivery_status ?? 'pending';
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'dispatched' => 'bg-blue-100 text-blue-800',
                                            'on_the_way' => 'bg-indigo-100 text-indigo-800',
                                            'delivered' => 'bg-green-100 text-green-800',
                                            'cancelled' => 'bg-red-100 text-red-800',
                                        ];
                                        $color = $statusColors[$status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $color }}">
                                        {{ ucwords(str_replace('_', ' ', $status)) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>