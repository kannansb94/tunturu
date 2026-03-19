@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-8 relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 p-8 shadow-2xl">
                <div class="absolute inset-0 bg-black/10"></div>
                <div class="relative z-10 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="p-4 bg-white/20 backdrop-blur-sm rounded-xl">
                            <span class="material-symbols-outlined text-5xl text-white">library_books</span>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-white mb-1">Book Inventory</h1>
                            <p class="text-white/90">Manage your library collection</p>
                        </div>
                    </div>
                    <a href="{{ route('library.admin.books.create') }}" class="px-6 py-3 bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white font-semibold rounded-xl transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined">add</span>
                        Add New Book
                    </a>
                </div>
            </div>



            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Books</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $books->total() }}</p>
                        </div>
                        <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-xl">
                            <span class="material-symbols-outlined text-3xl text-blue-600 dark:text-blue-400">menu_book</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Available</p>
                            <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-1">{{ $books->where('status', 'available')->count() }}</p>
                        </div>
                        <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-xl">
                            <span class="material-symbols-outlined text-3xl text-green-600 dark:text-green-400">check_circle</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Rented</p>
                            <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400 mt-1">{{ $books->where('status', 'rented')->count() }}</p>
                        </div>
                        <div class="p-3 bg-yellow-100 dark:bg-yellow-900/30 rounded-xl">
                            <span class="material-symbols-outlined text-3xl text-yellow-600 dark:text-yellow-400">schedule</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Categories</p>
                            <p class="text-3xl font-bold text-purple-600 dark:text-purple-400 mt-1">{{ $categories->count() }}</p>
                        </div>
                        <div class="p-3 bg-purple-100 dark:bg-purple-900/30 rounded-xl">
                            <span class="material-symbols-outlined text-3xl text-purple-600 dark:text-purple-400">category</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 mb-6">
                <form action="{{ route('library.admin.books.index') }}" method="GET" class="space-y-4">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="material-symbols-outlined text-gray-600 dark:text-gray-400">filter_list</span>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Filters</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Search -->
                        <div class="md:col-span-2">
                            <label for="search" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Search</label>
                            <div class="relative">
                                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Title, Author, or ISBN..." class="w-full pl-10 px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                                <span class="material-symbols-outlined absolute left-3 top-3.5 text-gray-400">search</span>
                            </div>
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Category</label>
                            <select name="category" id="category" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->name }}" {{ request('category') == $category->name ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Status</label>
                            <select name="status" id="status" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                                <option value="">All Status</option>
                                <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                                <option value="rented" {{ request('status') == 'rented' ? 'selected' : '' }}>Rented</option>
                                <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Sold</option>
                                <option value="lost" {{ request('status') == 'lost' ? 'selected' : '' }}>Lost</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-xl transition-all flex items-center gap-2">
                            <span class="material-symbols-outlined">search</span>
                            Apply Filters
                        </button>
                        @if(request()->anyFilled(['search', 'category', 'status']))
                            <a href="{{ route('library.admin.books.index') }}" class="px-6 py-3 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-semibold rounded-xl transition-all flex items-center gap-2">
                                <span class="material-symbols-outlined">close</span>
                                Clear
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Bulk Actions (Hidden by default) -->
            <div id="bulk-actions-container" class="hidden my-4 bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-4 items-center justify-between transition-all">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-purple-600 dark:text-purple-400">check_box</span>
                    <span class="text-gray-900 dark:text-white font-semibold">
                        <span id="selected-count">1</span> books selected
                    </span>
                </div>
                <div>
                    <form id="bulk-delete-form" action="{{ route('library.admin.books.bulkDelete') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="book_ids" id="bulk-book-ids" value="">
                        <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-all flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">delete</span>
                            Delete Selected
                        </button>
                    </form>
                </div>
            </div>

            <!-- Modern Table -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600">
                            <tr>
                                <th class="px-4 py-4 text-left">
                                    <input type="checkbox" id="select-all" class="w-4 h-4 text-purple-600 bg-white border-gray-300 rounded focus:ring-purple-500 dark:focus:ring-purple-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Book Details</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Pricing</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Stock</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($books as $book)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-4 py-4">
                                        <input type="checkbox" class="book-checkbox w-4 h-4 text-purple-600 bg-white border-gray-300 rounded focus:ring-purple-500 dark:focus:ring-purple-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" value="{{ $book->id }}" data-has-active-rentals="{{ \App\Models\Rental::where('book_id', $book->id)->where('status', 'active')->exists() ? 'true' : 'false' }}">
                                    </td>
                                    <!-- Book Details -->
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            <div class="flex-shrink-0 h-16 w-12 rounded-lg overflow-hidden shadow-md">
                                                @if($book->cover_image)
                                                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="h-full w-full object-cover">
                                                @else
                                                    <div class="h-full w-full bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-600 dark:to-gray-700 flex items-center justify-center">
                                                        <span class="material-symbols-outlined text-gray-400 text-xl">menu_book</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $book->title }}</div>
                                                <div class="text-sm text-gray-600 dark:text-gray-400">by {{ $book->author }}</div>
                                                @if($book->isbn)
                                                    <div class="text-xs text-gray-500 dark:text-gray-500 mt-1">ISBN: {{ $book->isbn }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Category -->
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 text-xs font-semibold rounded-full">{{ $book->category }}</span>
                                    </td>

                                    <!-- Pricing -->
                                    <td class="px-6 py-4">
                                        <div class="space-y-1">
                                            @if($book->type == 'rent' || $book->type == 'both')
                                                <div class="flex items-center gap-2">
                                                    <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-sm">schedule</span>
                                                    <span class="text-sm font-semibold text-gray-900 dark:text-white">₹{{ number_format($book->rental_price, 0) }}</span>
                                                    <span class="text-xs text-gray-500">/rent</span>
                                                </div>
                                            @endif
                                            @if($book->type == 'sale' || $book->type == 'both')
                                                <div class="flex items-center gap-2">
                                                    <span class="material-symbols-outlined text-green-600 dark:text-green-400 text-sm">sell</span>
                                                    <span class="text-sm font-semibold text-gray-900 dark:text-white">₹{{ number_format($book->selling_price, 0) }}</span>
                                                    <span class="text-xs text-gray-500">/buy</span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Stock -->
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center justify-center px-3 py-1 rounded-full text-sm font-bold
                                            {{ $book->quantity > 5 ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : ($book->quantity > 0 ? 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300' : 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300') }}">
                                            {{ $book->quantity }}
                                        </span>
                                    </td>

                                    <!-- Status -->
                                    <td class="px-6 py-4 text-center">
                                        @if($book->status === 'available')
                                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-xs font-bold rounded-full">
                                                <span class="material-symbols-outlined text-sm">check_circle</span>
                                                Available
                                            </span>
                                        @elseif($book->status === 'rented')
                                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300 text-xs font-bold rounded-full">
                                                <span class="material-symbols-outlined text-sm">schedule</span>
                                                Rented
                                            </span>
                                        @elseif($book->status === 'sold')
                                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-xs font-bold rounded-full">
                                                <span class="material-symbols-outlined text-sm">sell</span>
                                                Sold
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 text-xs font-bold rounded-full">
                                                <span class="material-symbols-outlined text-sm">error</span>
                                                {{ ucfirst($book->status) }}
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('library.admin.books.edit', $book) }}" class="inline-flex items-center gap-1 px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-all">
                                                <span class="material-symbols-outlined text-sm">edit</span>
                                                Edit
                                            </a>
                                            <form action="{{ route('library.admin.books.destroy', $book) }}" method="POST" class="inline-block" onsubmit="if('{{ \App\Models\Rental::where('book_id', $book->id)->where('status', 'active')->exists() ? 'true' : 'false' }}' === 'true') { alert('This book has active rentals and cannot be deleted until all copies are returned.'); return false; } return confirm('Are you sure you want to delete this book?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center gap-1 px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-lg transition-all">
                                                    <span class="material-symbols-outlined text-sm">delete</span>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <span class="material-symbols-outlined text-6xl text-gray-400 mb-4">library_books</span>
                                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No Books Found</h3>
                                            <p class="text-gray-600 dark:text-gray-400 mb-6">Start building your library by adding your first book.</p>
                                            <a href="{{ route('library.admin.books.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-xl transition-all">
                                                <span class="material-symbols-outlined">add</span>
                                                Add First Book
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($books->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                        {{ $books->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('select-all');
        const bookCheckboxes = document.querySelectorAll('.book-checkbox');
        const bulkActionsContainer = document.getElementById('bulk-actions-container');
        const selectedCountSpan = document.getElementById('selected-count');
        const bulkBookIdsInput = document.getElementById('bulk-book-ids');
        const bulkDeleteForm = document.getElementById('bulk-delete-form');

        function updateBulkActionsVisibility() {
            const selectedBoxes = document.querySelectorAll('.book-checkbox:checked');
            const selectedCount = selectedBoxes.length;

            if (selectedCount > 0) {
                selectedCountSpan.textContent = selectedCount;
                bulkActionsContainer.classList.remove('hidden');
                bulkActionsContainer.classList.add('flex');

                // Update hidden input with comma-separated IDs
                const selectedIds = Array.from(selectedBoxes).map(cb => cb.value).join(',');
                bulkBookIdsInput.value = selectedIds;
            } else {
                bulkActionsContainer.classList.remove('flex');
                bulkActionsContainer.classList.add('hidden');
                bulkBookIdsInput.value = '';
            }

            // Update "Select All" checkbox state
            if (bookCheckboxes.length > 0) {
                const selectableBoxes = Array.from(bookCheckboxes).filter(cb => cb.getAttribute('data-has-active-rentals') !== 'true');
                if (selectableBoxes.length > 0) {
                    const allSelectableChecked = selectableBoxes.every(cb => cb.checked);
                    selectAllCheckbox.checked = allSelectableChecked && selectedCount > 0;
                } else {
                    selectAllCheckbox.checked = false;
                }
            }
        }

        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                let hasRented = false;
                bookCheckboxes.forEach(cb => {
                    if (this.checked && cb.getAttribute('data-has-active-rentals') === 'true') {
                        hasRented = true;
                        cb.checked = false; // Do not select rented books
                    } else {
                        cb.checked = this.checked;
                    }
                });
                
                if (hasRented && this.checked) {
                    alert('Some books have active rentals and cannot be selected for deletion.');
                }
                
                updateBulkActionsVisibility();
            });
        }

        bookCheckboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                if (this.checked && this.getAttribute('data-has-active-rentals') === 'true') {
                    alert('This book has active rentals and cannot be deleted until all copies are returned.');
                    this.checked = false;
                }
                updateBulkActionsVisibility();
            });
        });

        if (bulkDeleteForm) {
            bulkDeleteForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const selectedBoxes = document.querySelectorAll('.book-checkbox:checked');
                let hasRented = false;
                
                selectedBoxes.forEach(cb => {
                    if (cb.getAttribute('data-has-active-rentals') === 'true') {
                        hasRented = true;
                    }
                });

                if (hasRented) {
                    alert('One or more selected books have active rentals. They cannot be deleted until all copies are returned.');
                    return;
                }

                if (confirm('Are you sure you want to delete the selected books? This action cannot be undone.')) {
                    this.submit();
                }
            });
        }
    });
</script>
@endpush