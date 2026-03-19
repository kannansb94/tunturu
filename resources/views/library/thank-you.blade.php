<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Order Placed') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-2xl p-8 text-center">
                <div
                    class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-green-100 dark:bg-green-900/20 mb-6">
                    <span
                        class="material-symbols-outlined text-6xl text-green-600 dark:text-green-400">check_circle</span>
                </div>

                <h1 class="text-3xl font-black text-gray-900 dark:text-white mb-2">Thank You!</h1>
                <p class="text-gray-600 dark:text-gray-400 text-lg mb-8">Your order has been placed successfully. A
                    confirmation email has been sent to you.</p>

                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6 mb-8 text-left max-w-md mx-auto">
                    <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Order Details</h3>
                    <div class="space-y-3">
                        <!-- Details passed from controller -->
                        @if(session('order_ids'))
                            <div class="flex flex-col gap-2">
                                <span class="text-gray-600 dark:text-gray-400">Order IDs</span>
                                <div class="flex flex-wrap gap-2 mt-1 z-10">
                                    @foreach(session('order_ids') as $id)
                                        <span
                                            class="px-2 py-1 bg-primary/10 text-primary border border-primary/20 rounded-md font-bold text-sm">#{{ $id }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('library.user.orders') }}"
                        class="px-8 py-3 bg-primary hover:bg-primary-hover text-white font-bold rounded-xl shadow-lg hover:shadow-primary/30 transition-all flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined">local_shipping</span>
                        Track Order
                    </a>

                    <a href="{{ route('library.index') }}"
                        class="px-8 py-3 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white font-bold rounded-xl hover:bg-gray-50 dark:hover:bg-gray-600 transition-all">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>