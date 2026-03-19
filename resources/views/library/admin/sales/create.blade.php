@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <a href="{{ route('library.admin.sales.index') }}"
                    class="inline-flex items-center gap-2 text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 mb-4">
                    <span class="material-symbols-outlined">arrow_back</span>
                    Back to Sales
                </a>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Record New Sale</h1>
            </div>

            <!-- Form -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-8">
                <form method="POST" action="{{ route('library.admin.sales.store') }}" class="space-y-6">
                    @csrf

                    <!-- Select Book -->
                    <div>
                        <label for="book_id"
                            class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <span class="material-symbols-outlined text-lg text-emerald-500">book</span>
                            Select Book
                            <span class="text-red-500">*</span>
                        </label>
                        <select id="book_id" name="book_id" required
                            class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-emerald-500 focus:ring-emerald-500">
                            <option value="">Choose a book...</option>
                            @foreach($books as $book)
                                <option value="{{ $book->id }}" data-price="{{ $book->selling_price }}"
                                    data-stock="{{ $book->quantity }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                    {{ $book->title }} by {{ $book->author }} (₹{{ number_format($book->selling_price, 2) }} -
                                    Stock: {{ $book->quantity }})
                                </option>
                            @endforeach
                        </select>
                        @error('book_id')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Select User -->
                    <div>
                        <label for="user_id"
                            class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <span class="material-symbols-outlined text-lg text-blue-500">person</span>
                            Select Buyer
                            <span class="text-red-500">*</span>
                        </label>
                        <select id="user_id" name="user_id" required
                            class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-emerald-500 focus:ring-emerald-500">
                            <option value="">Choose a user...</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Quantity -->
                    <div>
                        <label for="quantity"
                            class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <span class="material-symbols-outlined text-lg text-purple-500">format_list_numbered</span>
                            Quantity
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="quantity" name="quantity" value="{{ old('quantity', 1) }}" min="1" required
                            class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-emerald-500 focus:ring-emerald-500">
                        @error('quantity')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sale Date -->
                    <div>
                        <label for="sale_date"
                            class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <span class="material-symbols-outlined text-lg text-orange-500">calendar_today</span>
                            Sale Date
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="sale_date" name="sale_date" value="{{ old('sale_date', date('Y-m-d')) }}"
                            required
                            class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-emerald-500 focus:ring-emerald-500">
                        @error('sale_date')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Payment Method -->
                    <div>
                        <label for="payment_method"
                            class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <span class="material-symbols-outlined text-lg text-gray-500">payments</span>
                            Payment Method
                        </label>
                        <select id="payment_method" name="payment_method"
                            class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-emerald-500 focus:ring-emerald-500">
                            <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="upi" {{ old('payment_method') == 'upi' ? 'selected' : '' }}>UPI</option>
                            <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Card</option>
                            <option value="other" {{ old('payment_method') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('payment_method')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sale Info Display -->
                    <div id="sale-info"
                        class="hidden p-4 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl border border-emerald-200 dark:border-emerald-800">
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Sale Summary</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Price per Unit:</span>
                                <span class="font-semibold text-gray-900 dark:text-white" id="display-price">-</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Quantity:</span>
                                <span class="font-semibold text-gray-900 dark:text-white" id="display-quantity">-</span>
                            </div>
                            <div class="flex justify-between pt-2 border-t border-emerald-200 dark:border-emerald-700">
                                <span class="text-gray-600 dark:text-gray-400 text-lg">Total Amount:</span>
                                <span class="font-bold text-emerald-600 dark:text-emerald-400 text-lg"
                                    id="display-total">-</span>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex gap-4">
                        <button type="submit"
                            class="flex-1 px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl shadow-lg transition-all">
                            Record Sale
                        </button>
                        <a href="{{ route('library.admin.sales.index') }}"
                            class="px-6 py-3 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-semibold rounded-xl transition-all">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const bookSelect = document.getElementById('book_id');
            const quantityInput = document.getElementById('quantity');
            const saleInfo = document.getElementById('sale-info');

            function updateSaleInfo() {
                const selectedOption = bookSelect.options[bookSelect.selectedIndex];
                const quantity = parseInt(quantityInput.value) || 0;

                if (selectedOption.value && quantity > 0) {
                    const price = parseFloat(selectedOption.dataset.price);
                    const stock = parseInt(selectedOption.dataset.stock);
                    const total = price * quantity;

                    document.getElementById('display-price').textContent = '₹' + price.toFixed(2);
                    document.getElementById('display-quantity').textContent = quantity;
                    document.getElementById('display-total').textContent = '₹' + total.toFixed(2);

                    if (quantity > stock) {
                        quantityInput.setCustomValidity('Quantity exceeds available stock (' + stock + ')');
                    } else {
                        quantityInput.setCustomValidity('');
                    }

                    saleInfo.classList.remove('hidden');
                } else {
                    saleInfo.classList.add('hidden');
                }
            }

            bookSelect.addEventListener('change', updateSaleInfo);
            quantityInput.addEventListener('input', updateSaleInfo);
        });
    </script>
@endsection