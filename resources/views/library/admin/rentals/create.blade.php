@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <a href="{{ route('library.admin.rentals.index') }}" class="inline-flex items-center gap-2 text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 mb-4">
                    <span class="material-symbols-outlined">arrow_back</span>
                    Back to Rentals
                </a>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Create New Rental</h1>
            </div>

            <!-- Form -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-8">
                <form method="POST" action="{{ route('library.admin.rentals.store') }}" class="space-y-6">
                    @csrf

                    <!-- Select Book -->
                    <div>
                        <label for="book_id" class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <span class="material-symbols-outlined text-lg text-blue-500">book</span>
                            Select Book
                            <span class="text-red-500">*</span>
                        </label>
                        <select id="book_id" name="book_id" required class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Choose a book...</option>
                            @foreach($books as $book)
                                <option value="{{ $book->id }}" 
                                    data-rental-price="{{ $book->rental_price }}"
                                    data-duration="{{ $book->rental_duration_days }}"
                                    data-late-fee="{{ $book->late_fee_per_day }}"
                                    {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                    {{ $book->title }} by {{ $book->author }} (₹{{ number_format($book->rental_price, 2) }}/{{ $book->rental_duration_days }} days)
                                </option>
                            @endforeach
                        </select>
                        @error('book_id')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Select User -->
                    <div>
                        <label for="user_id" class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <span class="material-symbols-outlined text-lg text-green-500">person</span>
                            Select Renter
                            <span class="text-red-500">*</span>
                        </label>
                        <select id="user_id" name="user_id" required class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-blue-500 focus:ring-blue-500">
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

                    <!-- Rental Date -->
                    <div>
                        <label for="rental_date" class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <span class="material-symbols-outlined text-lg text-purple-500">calendar_today</span>
                            Rental Date
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="rental_date" name="rental_date" value="{{ old('rental_date', date('Y-m-d')) }}" required class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-blue-500 focus:ring-blue-500">
                        @error('rental_date')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Rental Info Display -->
                    <div id="rental-info" class="hidden p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-200 dark:border-blue-800">
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Rental Information</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Rental Price:</span>
                                <span class="font-semibold text-gray-900 dark:text-white" id="display-rental-price">-</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Rental Duration:</span>
                                <span class="font-semibold text-gray-900 dark:text-white" id="display-duration">-</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Late Fee (per day):</span>
                                <span class="font-semibold text-red-600 dark:text-red-400" id="display-late-fee">-</span>
                            </div>
                            <div class="flex justify-between pt-2 border-t border-blue-200 dark:border-blue-700">
                                <span class="text-gray-600 dark:text-gray-400">Expected Return Date:</span>
                                <span class="font-bold text-gray-900 dark:text-white" id="display-return-date">-</span>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex gap-4">
                        <button type="submit" class="flex-1 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-lg transition-all">
                            Create Rental
                        </button>
                        <a href="{{ route('library.admin.rentals.index') }}" class="px-6 py-3 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-semibold rounded-xl transition-all">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bookSelect = document.getElementById('book_id');
            const rentalDateInput = document.getElementById('rental_date');
            const rentalInfo = document.getElementById('rental-info');

            function updateRentalInfo() {
                const selectedOption = bookSelect.options[bookSelect.selectedIndex];
                const rentalDate = rentalDateInput.value;

                if (selectedOption.value && rentalDate) {
                    const rentalPrice = selectedOption.dataset.rentalPrice;
                    const duration = selectedOption.dataset.duration;
                    const lateFee = selectedOption.dataset.lateFee;

                    // Calculate expected return date
                    const rental = new Date(rentalDate);
                    rental.setDate(rental.getDate() + parseInt(duration));
                    const returnDate = rental.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });

                    document.getElementById('display-rental-price').textContent = '₹' + parseFloat(rentalPrice).toFixed(2);
                    document.getElementById('display-duration').textContent = duration + ' days';
                    document.getElementById('display-late-fee').textContent = '₹' + parseFloat(lateFee).toFixed(2);
                    document.getElementById('display-return-date').textContent = returnDate;

                    rentalInfo.classList.remove('hidden');
                } else {
                    rentalInfo.classList.add('hidden');
                }
            }

            bookSelect.addEventListener('change', updateRentalInfo);
            rentalDateInput.addEventListener('change', updateRentalInfo);
        });
    </script>
@endsection
