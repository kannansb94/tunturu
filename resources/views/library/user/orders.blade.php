<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display font-black text-3xl leading-tight text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600">
            {{ __('Order Tracking') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen relative">
        <!-- Subtle Background Gradients -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
            <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-purple-200/30 blur-[120px]"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] rounded-full bg-pink-200/30 blur-[120px]"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="mb-8">
                <a href="{{ route('library.user') }}"
                    class="inline-flex items-center gap-2 text-gray-500 hover:text-gray-900 transition-colors group">
                    <span class="p-2 rounded-full bg-white group-hover:bg-gray-100 shadow-sm border border-gray-200 transition-colors">
                        <span class="material-symbols-outlined text-sm">arrow_back</span>
                    </span>
                    <span class="font-medium text-sm">Back to Dashboard</span>
                </a>
            </div>

            @if($orders->isEmpty())
                <div class="bg-white border border-gray-100 rounded-3xl p-16 text-center shadow-xl">
                    <div class="w-24 h-24 mx-auto bg-gradient-to-br from-purple-500/10 to-pink-500/10 rounded-full flex items-center justify-center mb-6">
                        <span class="material-symbols-outlined text-5xl text-purple-600">shopping_cart</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">No Orders Yet</h3>
                    <p class="text-gray-500 mb-8 max-w-md mx-auto">Your reading journey begins with a single page. Explore our collection and find your next adventure.</p>
                    <a href="{{ route('library.index') }}"
                        class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold rounded-xl shadow-lg shadow-purple-500/25 hover:shadow-purple-500/40 hover:scale-105 transition-all duration-300">
                        Browse Collection
                    </a>
                </div>
            @else
                <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden shadow-xl">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50 text-gray-500 text-xs font-black uppercase tracking-wider border-b border-gray-100">
                                    <th class="p-4 md:p-6 font-medium">Order Details</th>
                                    <th class="p-4 md:p-6 font-medium">Date</th>
                                    <th class="p-4 md:p-6 font-medium">Payment</th>
                                    <th class="p-4 md:p-6 font-medium">Total</th>
                                    <th class="p-4 md:p-6 font-medium">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($orders as $order)
                                    <tr class="hover:bg-purple-50/30 transition-colors group">
                                        <td class="p-4 md:p-6 flex items-center gap-4">
                                            <div class="w-12 h-16 md:w-16 md:h-20 rounded-lg overflow-hidden bg-gray-100 shadow-sm shrink-0 border border-gray-200 group-hover:border-purple-200 transition-colors">
                                                @if($order->book->cover_image)
                                                    <img src="{{ asset('storage/' . $order->book->cover_image) }}" alt="{{ $order->book->title }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                        <span class="material-symbols-outlined text-sm md:text-base">auto_stories</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-sm md:text-base text-gray-900 group-hover:text-purple-600 transition-colors md:truncate md:max-w-xs">{{ $order->book->title }}</h4>
                                                <span class="text-xs font-medium text-gray-500 block mb-1">ID: #{{ $order->id }}</span>
                                                <span class="text-xs text-gray-400 block">{{ $order->quantity }} Copy</span>
                                            </div>
                                        </td>
                                        <td class="p-4 md:p-6 text-sm text-gray-600 whitespace-nowrap">
                                            {{ $order->sale_date->format('M d, Y') }}
                                        </td>
                                        <td class="p-4 md:p-6">
                                            <span class="px-2.5 py-1 text-[10px] font-black uppercase tracking-widest bg-blue-50 text-blue-600 rounded-full border border-blue-100">
                                                {{ $order->payment_method }}
                                            </span>
                                        </td>
                                        <td class="p-4 md:p-6 font-bold text-gray-900 whitespace-nowrap">
                                            ₹{{ number_format($order->total_amount, 2) }}
                                        </td>
                                        <td class="p-4 md:p-6">
                                            @if($order->delivery_status == 'cancelled')
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-red-50 text-red-600 border border-red-100">
                                                    Cancelled
                                                </span>
                                            @elseif($order->delivery_status == 'delivered')
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-green-50 text-green-600 border border-green-100">
                                                    Delivered
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-purple-50 text-purple-600 border border-purple-100">
                                                    {{ ucwords(str_replace('_', ' ', $order->delivery_status ?? 'pending')) }}
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>