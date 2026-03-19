@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Pending Donations</h2>
                <a href="{{ route('library.admin.donations.status') }}"
                    class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition-colors flex items-center gap-2 shadow-sm font-semibold text-sm">
                    <span class="material-symbols-outlined text-sm">inventory</span>
                    View Processed Donations
                </a>
            </div>



            @if(session('success'))
                <div class="mb-6 px-4 py-3 bg-green-500/10 border border-green-500/20 text-green-700 dark:text-green-400 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 px-4 py-3 bg-red-500/10 border border-red-500/20 text-red-500 rounded-md">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Donation Settings Form -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700 mb-8">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-indigo-500">settings</span>
                        Donation Drop-off Configuration
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                        Configure the contact details and address shown to users on the "Donate a Book" page where they can send their physical books.
                    </p>
                    
                    <form method="POST" action="{{ route('library.admin.donations.settings.update') }}">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full lg:w-3/4">
                            <!-- Contact Name -->
                            <div>
                                <label for="donation_contact_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Contact Person Name
                                </label>
                                <input type="text" name="donation_contact_name" id="donation_contact_name" 
                                    value="{{ old('donation_contact_name', $settings['donation_contact_name']) }}"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    placeholder="e.g. John Doe">
                            </div>

                            <!-- Contact Number -->
                            <div>
                                <label for="donation_contact_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Contact Number
                                </label>
                                <input type="text" name="donation_contact_number" id="donation_contact_number" 
                                    value="{{ old('donation_contact_number', $settings['donation_contact_number']) }}"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    placeholder="e.g. +91 9876543210">
                                <!-- Additional Notes -->
                            <div class="md:col-span-2">
                                <label for="donation_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Additional Notes / Instructions
                                </label>
                                <textarea name="donation_notes" id="donation_notes" rows="2"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    placeholder="e.g. Leave books at the front desk, Open Mon-Fri 9AM-5PM...">{{ old('donation_notes', $settings['donation_notes'] ?? '') }}</textarea>
                            </div>
                        </div>

                            <!-- Address -->
                            <div class="md:col-span-2">
                                <label for="donation_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Library Drop-off Address
                                </label>
                                <textarea name="donation_address" id="donation_address" rows="3"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    placeholder="Please enter the full address where books should be shipped or dropped off...">{{ old('donation_address', $settings['donation_address']) }}</textarea>
                            </div>
                        </div>
                        
                        <div class="mt-4 flex justify-end w-full lg:w-3/4">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors flex items-center gap-2 shadow-sm font-semibold text-sm">
                                <span class="material-symbols-outlined text-sm">save</span>
                                Save Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Pending Donations List -->
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if($pendingBooks->isEmpty())
                        <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                            <span class="material-symbols-outlined text-4xl mb-2">inbox</span>
                            <p>No pending donations found.</p>
                        </div>
                    @else
                            <div class="grid grid-cols-1 gap-6">
                                @foreach($pendingBooks as $book)
                                        <div
                                            class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6 border border-gray-200 dark:border-gray-600 flex flex-col md:flex-row gap-6">
                                            <!-- Book Cover -->
                                            <div
                                                class="flex-shrink-0 w-full md:w-32 h-48 bg-gray-200 dark:bg-gray-600 rounded-lg overflow-hidden flex items-center justify-center">
                                                @if($book->cover_image)
                                                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}"
                                                        class="w-full h-full object-cover">
                                                @else
                                                    <span class="material-symbols-outlined text-gray-400 text-4xl">book</span>
                                                @endif
                                            </div>

                                            <!-- Details -->
                                            <div class="flex-grow">
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">{{ $book->title }}
                                                        </h3>
                                                        <p class="text-gray-600 dark:text-gray-300 mb-2">by {{ $book->author }}</p>
                                                        <div class="space-y-2 text-sm">
                                                            <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                                                                <span class="material-symbols-outlined text-sm">person</span>
                                                                <span><strong>Donor:</strong> {{ $book->donor->name ?? 'Unknown' }}</span>
                                                            </div>
                                                            <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                                                                <span class="material-symbols-outlined text-sm">mail</span>
                                                                <span><strong>Email:</strong> {{ $book->donor->email ?? 'N/A' }}</span>
                                                            </div>
                                                            @if($book->donor_location)
                                                                <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                                                                    <span class="material-symbols-outlined text-sm">location_on</span>
                                                                    <span><strong>Location:</strong> {{ $book->donor_location }}</span>
                                                                </div>
                                                            @endif
                                                            <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                                                                <span class="material-symbols-outlined text-sm">calendar_today</span>
                                                                <span><strong>Donated:</strong>
                                                                    {{ $book->created_at->format('M d, Y h:i A') }}</span>
                                                            </div>
                                                            @if($book->isbn)
                                                                <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                                                                    <span class="material-symbols-outlined text-sm">tag</span>
                                                                    <span><strong>ISBN:</strong> {{ $book->isbn }}</span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <p class="mt-4 text-gray-600 dark:text-gray-300 text-sm line-clamp-3">
                                                    {{ $book->description ?? 'No description provided.' }}
                                                </p>

                                                <!-- Approval Form -->
                                                <form action="{{ route('library.admin.donations.approve', $book) }}" method="POST"
                                                    class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-600">
                                                    @csrf
                                                    @method('PATCH')

                                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                                        <!-- Category -->
                                                        <div>
                                                            <label
                                                                class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Category</label>
                                                            <select name="category" required
                                                                class="w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm">
                                                                @foreach(\App\Models\Category::all() as $category)
                                                                    <option value="{{ $category->name }}" {{ ($book->category == $category->name) ? 'selected' : '' }}>{{ $category->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <!-- Type -->
                                                        <div>
                                                            <label
                                                                class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Type</label>
                                                            <select name="type" id="type_{{ $book->id }}"
                                                                onchange="togglePrice_{{ $book->id }}()" required
                                                                class="w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm">
                                                                <option value="rent" {{ $book->type == 'rent' ? 'selected' : '' }}>Rent Only
                                                                </option>
                                                                <option value="sale" {{ $book->type == 'sale' ? 'selected' : '' }}>Sale Only
                                                                </option>
                                                                <option value="both" {{ $book->type == 'both' ? 'selected' : '' }}>Both
                                                                </option>
                                                            </select>
                                                        </div>

                                                        <!-- Prices -->
                                                        <div id="price_container_{{ $book->id }}">
                                                            <div class="grid grid-cols-2 gap-2">
                                                                <div id="rent_price_{{ $book->id }}">
                                                                    <label
                                                                        class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Rent
                                                                        Price</label>
                                                                    <input type="number" name="rental_price"
                                                                        value="{{ $book->rental_price }}"
                                                                        class="w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm">
                                                                </div>
                                                                <div id="sell_price_{{ $book->id }}">
                                                                    <label
                                                                        class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Sell
                                                                        Price</label>
                                                                    <input type="number" name="selling_price"
                                                                        value="{{ $book->selling_price }}"
                                                                        class="w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="flex justify-end gap-3">
                                                        <button type="submit" name="action" value="approve"
                                                            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition-colors flex items-center gap-1">
                                                            <span class="material-symbols-outlined text-sm">check_circle</span>
                                                            Approve & Add to Inventory
                                                        </button>
                                                </form>

                                                <form action="{{ route('library.admin.donations.reject', $book) }}" method="POST"
                                                    class="inline"
                                                    onsubmit="return confirm('Are you sure you want to reject this donation?');">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 dark:bg-red-900/30 dark:hover:bg-red-900/50 dark:text-red-300 rounded-lg text-sm font-medium transition-colors flex items-center gap-1 ml-3 mt-6">
                                                        <span class="material-symbols-outlined text-sm">cancel</span>
                                                        Reject
                                                    </button>
                                                </form>
                                            </div>

                                            <script>
                                                function togglePrice_{{ $book->id }}() {
                                                    const type = document.getElementById('type_{{ $book->id }}').value;
                                                    const rentDiv = document.getElementById('rent_price_{{ $book->id }}');
                                                    const sellDiv = document.getElementById('sell_price_{{ $book->id }}');

                                                    if (type === 'rent') {
                                                        rentDiv.style.display = 'block';
                                                        sellDiv.style.display = 'none';
                                                    } else if (type === 'sale') {
                                                        rentDiv.style.display = 'none';
                                                        sellDiv.style.display = 'block';
                                                    } else {
                                                        rentDiv.style.display = 'block';
                                                        sellDiv.style.display = 'block';
                                                    }
                                                }
                                                // Initialize
                                                document.addEventListener('DOMContentLoaded', function () {
                                                    togglePrice_{{ $book->id }}();
                                                });
                                            </script>
                                        </div>
                                    </div>
                                @endforeach
                        </div>
                    @endif

                <div class="mt-6">
                    {{ $pendingBooks->links() }}
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection