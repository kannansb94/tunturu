@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <a href="{{ route('library.admin.users.index') }}"
                class="flex items-center text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white mb-6">
                <span class="material-symbols-outlined mr-1">arrow_back</span> Back to Users
            </a>

            <!-- User Info & KYC -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Profile Card -->
                <div class="md:col-span-1 bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <div class="flex flex-col items-center">
                        <span class="inline-flex items-center justify-center h-24 w-24 rounded-full bg-gray-500 mb-4">
                            <span class="text-3xl font-medium text-white">{{ substr($user->name, 0, 1) }}</span>
                        </span>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h3>
                        <p class="text-gray-500 dark:text-gray-400">{{ $user->role }}</p>

                        <div class="mt-6 w-full space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Email:</span>
                                <span class="text-gray-900 dark:text-gray-200">{{ $user->email }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Phone:</span>
                                <span class="text-gray-900 dark:text-gray-200">{{ $user->phone ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Address:</span>
                                <span
                                    class="text-gray-900 dark:text-gray-200 text-right">{{ $user->address ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Joined:</span>
                                <span
                                    class="text-gray-900 dark:text-gray-200">{{ $user->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">KYC Status:</span>
                                <span
                                    class="font-bold {{ $user->kyc_status === 'approved' ? 'text-green-600' : ($user->kyc_status === 'rejected' ? 'text-red-600' : 'text-yellow-600') }}">
                                    {{ ucfirst($user->kyc_status) }}
                                </span>
                            </div>
                        </div>

                        <!-- KYC Actions -->
                        @if($user->kyc_status === 'pending')
                            <div class="mt-8 flex gap-3 w-full">
                                <form action="{{ route('library.admin.users.kyc.approve', $user) }}" method="POST"
                                    class="flex-1">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition">Approve</button>
                                </form>
                                <form action="{{ route('library.admin.users.kyc.reject', $user) }}" method="POST"
                                    class="flex-1">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium transition">Reject</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- KYC Documents -->
                <div class="md:col-span-2 bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">KYC Documents</h3>

                    @if(!$user->aadhaar_path && !$user->pan_path)
                        <div class="text-gray-500 italic">No documents uploaded yet.</div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach(['aadhaar_path' => 'Aadhaar Card', 'pan_path' => 'PAN Card', 'address_proof_path' => 'Address Proof'] as $field => $label)
                                @if($user->$field)
                                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                        <div class="font-medium text-gray-700 dark:text-gray-300 mb-2">{{ $label }}</div>
                                        <div
                                            class="aspect-video bg-gray-100 dark:bg-gray-900 rounded flex items-center justify-center overflow-hidden">
                                            @php
                                                $ext = pathinfo($user->$field, PATHINFO_EXTENSION);
                                                $docType = str_replace('_path', '', $field);
                                            @endphp

                                            @if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif']))
                                                <a href="{{ route('library.admin.users.document', ['user' => $user, 'type' => $docType]) }}" target="_blank">
                                                    <img src="{{ route('library.admin.users.document', ['user' => $user, 'type' => $docType]) }}" alt="{{ $label }}"
                                                        class="w-full h-full object-contain">
                                                </a>
                                            @elseif(strtolower($ext) === 'pdf')
                                                <a href="{{ route('library.admin.users.document', ['user' => $user, 'type' => $docType]) }}" target="_blank"
                                                    class="flex flex-col items-center text-blue-600 hover:underline">
                                                    <span class="material-symbols-outlined text-4xl">picture_as_pdf</span>
                                                    <span class="text-xs mt-1">View PDF</span>
                                                </a>
                                            @else
                                                <a href="{{ route('library.admin.users.document', ['user' => $user, 'type' => $docType]) }}" target="_blank"
                                                    class="flex flex-col items-center text-blue-600 hover:underline">
                                                    <span class="material-symbols-outlined text-4xl">description</span>
                                                    <span class="text-xs mt-1">Download</span>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- History Section (Placeholder for now) -->
            <!-- Activity History -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mt-8">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Activity History</h3>

                <div x-data="{ activeTab: 'rentals' }">
                    <div class="border-b border-gray-200 dark:border-gray-700 mb-4">
                        <nav class="-mb-px flex space-x-8">
                            <button @click="activeTab = 'rentals'"
                                :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'rentals', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'rentals' }"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                Rentals ({{ $user->rentals->count() }})
                            </button>
                            <button @click="activeTab = 'purchases'"
                                :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'purchases', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'purchases' }"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                Purchases ({{ $user->sales->count() }})
                            </button>
                        </nav>
                    </div>

                    <!-- Rentals Tab -->
                    <div x-show="activeTab === 'rentals'" class="space-y-4">
                        @if ($user->rentals->isEmpty())
                            <p class="text-gray-500 italic">No rental history found.</p>
                        @else
                            <div class="overflow-x-auto">
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
                                                Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach ($user->rentals as $rental)
                                            <tr>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $rental->book->title ?? 'Unknown Book' }}
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
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                    <!-- Purchases Tab -->
                    <div x-show="activeTab === 'purchases'" class="space-y-4" style="display: none;">
                        @if ($user->sales->isEmpty())
                            <p class="text-gray-500 italic">No purchase history found.</p>
                        @else
                            <div class="overflow-x-auto">
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
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach ($user->sales as $sale)
                                            <tr>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $sale->book->title ?? 'Unknown Book' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $sale->sale_date->format('M d, Y') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                    ₹{{ number_format($sale->total_amount, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection