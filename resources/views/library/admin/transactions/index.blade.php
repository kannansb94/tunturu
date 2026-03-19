@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8 relative overflow-hidden rounded-2xl bg-gradient-to-r from-purple-600 via-pink-600 to-red-600 p-8 shadow-2xl">
                <div class="absolute inset-0 bg-black/10"></div>
                <div class="relative z-10 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="p-4 bg-white/20 backdrop-blur-sm rounded-full">
                            <span class="material-symbols-outlined text-5xl text-white">receipt_long</span>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-white mb-1">Transaction History</h1>
                            <p class="text-white/90">View all financial transactions and wallet activity</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transactions Table -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Message</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">User</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Date</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Amount</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Type</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($transactions as $transaction)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <p class="text-sm text-gray-900 dark:text-white font-medium">{{ $transaction->description }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm">
                                            <p class="font-medium text-gray-900 dark:text-white">{{ $transaction->user->name }}</p>
                                            <p class="text-gray-500">{{ $transaction->user->email }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $transaction->created_at->format('M d, Y h:i A') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-bold {{ $transaction->type === 'credit' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $transaction->type === 'credit' ? '+' : '-' }}₹{{ number_format($transaction->amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $transaction->type === 'credit' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($transaction->type) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
