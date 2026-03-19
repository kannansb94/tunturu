@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Card -->
            <div class="mb-6 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 rounded-2xl shadow-xl p-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="p-4 bg-white/20 backdrop-blur-sm rounded-xl">
                            <span class="material-symbols-outlined text-5xl text-white">edit_note</span>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-white">Edit Book</h1>
                            <p class="text-white/90 mt-1">Update details for <span
                                    class="font-bold">{{ $book->title }}</span></p>
                        </div>
                    </div>
                    <a href="{{ route('library.admin.books.index') }}"
                        class="px-6 py-3 bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white font-semibold rounded-xl transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined">arrow_back</span>
                        Back
                    </a>
                </div>
            </div>

            <form action="{{ route('library.admin.books.update', $book) }}" method="POST" enctype="multipart/form-data"
                x-data="{ type: '{{ old('type', $book->type) }}', category: '{{ old('category', $book->category) }}' }">
                @csrf
                @method('PUT')

                @if ($errors->any())
                    <div class="mb-6 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 rounded-xl p-6">
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-red-600 dark:text-red-400 text-2xl">error</span>
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-red-800 dark:text-red-300 mb-2">Please correct the following
                                    errors:</h3>
                                <ul class="list-disc list-inside space-y-1 text-red-700 dark:text-red-400">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Left Sidebar - Cover Image -->
                    <div class="lg:col-span-1">
                        <div
                            class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 sticky top-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                <span class="material-symbols-outlined text-blue-600">image</span>
                                Book Cover
                            </h3>
                            <div class="space-y-4">
                                <div
                                    class="aspect-[3/4] bg-gray-100 dark:bg-gray-700 rounded-xl overflow-hidden border-2 border-dashed border-gray-300 dark:border-gray-600">
                                    @if($book->cover_image)
                                        <img id="cover-image" src="{{ asset('storage/' . $book->cover_image) }}"
                                            alt="{{ $book->title }}" class="w-full h-full object-cover">
                                    @else
                                        <div id="cover-preview" class="hidden w-full h-full">
                                            <img id="cover-image-new" src="" alt="Cover preview"
                                                class="w-full h-full object-cover">
                                        </div>
                                        <div id="cover-placeholder" class="w-full h-full flex items-center justify-center">
                                            <div class="text-center p-6">
                                                <span class="material-symbols-outlined text-6xl text-gray-400 mb-2">book</span>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">No cover image</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <input type="file" name="cover_image" id="cover_image" accept="image/*"
                                    class="w-full text-sm text-gray-600 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900/30 dark:file:text-blue-400"
                                    onchange="previewCover(event)">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Upload a new image to replace the
                                    current cover</p>
                                @error('cover_image')
                                    <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Basic Information Card -->
                        <div
                            class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                            <h3
                                class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2 pb-3 border-b border-gray-200 dark:border-gray-700">
                                <span class="material-symbols-outlined text-purple-600">menu_book</span>
                                Basic Information
                            </h3>
                            <div class="space-y-4">
                                <!-- Title -->
                                <div>
                                    <label for="title"
                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Book Title
                                        *</label>
                                    <input type="text" name="title" id="title" value="{{ old('title', $book->title) }}"
                                        required
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                                        placeholder="Enter book title">
                                    @error('title')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Author -->
                                    <div>
                                        <label for="author"
                                            class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Author
                                            *</label>
                                        <input type="text" name="author" id="author"
                                            value="{{ old('author', $book->author) }}" required
                                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                                            placeholder="Author name">
                                        @error('author')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- ISBN -->
                                    <div>
                                        <label for="isbn"
                                            class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">ISBN</label>
                                        <input type="text" name="isbn" id="isbn" value="{{ old('isbn', $book->isbn) }}"
                                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                                            placeholder="ISBN code">
                                        @error('isbn')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Description -->
                                <div>
                                    <label for="description"
                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Description</label>
                                    <textarea name="description" id="description" rows="4"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all resize-none"
                                        placeholder="Brief description of the book">{{ old('description', $book->description) }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Language -->
                                @php
                                    $predefinedLanguages = ['Tamil', 'Hindi', 'Telugu', 'Malayalam', 'Kannada', 'Bengali', 'Marathi', 'Gujarati', 'Punjabi', 'Urdu', 'Odia', 'Assamese', 'Sanskrit', 'English'];
                                    $currentLanguage = old('language', $book->language);
                                    $isOther = $currentLanguage && !in_array($currentLanguage, $predefinedLanguages);
                                    $displayLanguage = $isOther ? 'Other' : $currentLanguage;
                                @endphp
                                <div x-data="{ language: '{{ $displayLanguage }}' }">
                                    <label for="language"
                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Book
                                        Language</label>
                                    <select name="language" id="language" x-model="language"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                                        <option value="">Select Language</option>
                                        <option value="Tamil" {{ $displayLanguage == 'Tamil' ? 'selected' : '' }}>Tamil
                                        </option>
                                        <option value="Hindi" {{ $displayLanguage == 'Hindi' ? 'selected' : '' }}>Hindi
                                        </option>
                                        <option value="Telugu" {{ $displayLanguage == 'Telugu' ? 'selected' : '' }}>Telugu
                                        </option>
                                        <option value="Malayalam" {{ $displayLanguage == 'Malayalam' ? 'selected' : '' }}>
                                            Malayalam</option>
                                        <option value="Kannada" {{ $displayLanguage == 'Kannada' ? 'selected' : '' }}>Kannada
                                        </option>
                                        <option value="Bengali" {{ $displayLanguage == 'Bengali' ? 'selected' : '' }}>Bengali
                                        </option>
                                        <option value="Marathi" {{ $displayLanguage == 'Marathi' ? 'selected' : '' }}>Marathi
                                        </option>
                                        <option value="Gujarati" {{ $displayLanguage == 'Gujarati' ? 'selected' : '' }}>
                                            Gujarati</option>
                                        <option value="Punjabi" {{ $displayLanguage == 'Punjabi' ? 'selected' : '' }}>Punjabi
                                        </option>
                                        <option value="Urdu" {{ $displayLanguage == 'Urdu' ? 'selected' : '' }}>Urdu</option>
                                        <option value="Odia" {{ $displayLanguage == 'Odia' ? 'selected' : '' }}>Odia</option>
                                        <option value="Assamese" {{ $displayLanguage == 'Assamese' ? 'selected' : '' }}>
                                            Assamese</option>
                                        <option value="Sanskrit" {{ $displayLanguage == 'Sanskrit' ? 'selected' : '' }}>
                                            Sanskrit</option>
                                        <option value="English" {{ $displayLanguage == 'English' ? 'selected' : '' }}>English
                                        </option>
                                        <option value="Other" {{ $displayLanguage == 'Other' ? 'selected' : '' }}>Other
                                        </option>
                                    </select>
                                    @error('language')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror

                                    <!-- Other Language Input (shown when "Other" is selected) -->
                                    <div x-show="language === 'Other'" x-cloak class="mt-3">
                                        <label for="language_other"
                                            class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Specify
                                            Language *</label>
                                        <input type="text" name="language_other" id="language_other"
                                            value="{{ old('language_other', $isOther ? $currentLanguage : '') }}"
                                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                                            placeholder="Enter language name">
                                        @error('language_other')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Category & Type Card -->
                        <div
                            class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                            <h3
                                class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2 pb-3 border-b border-gray-200 dark:border-gray-700">
                                <span class="material-symbols-outlined text-green-600">category</span>
                                Classification
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Category -->
                                <div>
                                    <label for="category"
                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Category
                                        *</label>
                                    <select name="category" id="category" required x-model="category"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->name }}" {{ old('category', $book->category) == $category->name ? 'selected' : '' }}>{{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Type -->
                                <div>
                                    <label for="type"
                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Availability
                                        Type *</label>
                                    <select name="type" id="type" x-model="type" required
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                                        <option value="rent" {{ old('type', $book->type) == 'rent' ? 'selected' : '' }}>For
                                            Rent</option>
                                        <option value="sale" {{ old('type', $book->type) == 'sale' ? 'selected' : '' }}>For
                                            Sale</option>
                                        <option value="both" {{ old('type', $book->type) == 'both' ? 'selected' : '' }}>Both
                                        </option>
                                    </select>
                                    @error('type')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div>
                                    <label for="status"
                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Status
                                        *</label>
                                    <select name="status" id="status" required
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                                        <option value="available" {{ old('status', $book->status) == 'available' ? 'selected' : '' }}>Available</option>
                                        <option value="rented" {{ old('status', $book->status) == 'rented' ? 'selected' : '' }}>Rented</option>
                                        <option value="sold" {{ old('status', $book->status) == 'sold' ? 'selected' : '' }}>
                                            Sold</option>
                                        <option value="lost" {{ old('status', $book->status) == 'lost' ? 'selected' : '' }}>
                                            Lost</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Quantity -->
                                <div>
                                    <label for="quantity"
                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Quantity
                                        *</label>
                                    <input type="number" name="quantity" id="quantity"
                                        value="{{ old('quantity', $book->quantity) }}" min="0" required
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                                        placeholder="0">
                                    @error('quantity')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Pricing Card -->
                        <div
                            class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                            <h3
                                class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2 pb-3 border-b border-gray-200 dark:border-gray-700">
                                <span class="material-symbols-outlined text-yellow-600">payments</span>
                                Pricing & Rental Details
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Rental Price -->
                                <div x-show="type === 'rent' || type === 'both'">
                                    <label for="rental_price"
                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Rental
                                        Price (₹)</label>
                                    <input type="number" name="rental_price" id="rental_price"
                                        value="{{ old('rental_price', $book->rental_price) }}" step="0.01" min="0"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all"
                                        placeholder="0.00">
                                    @error('rental_price')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Rental Duration -->
                                <div x-show="type === 'rent' || type === 'both'">
                                    <label for="rental_duration_days"
                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Rental
                                        Duration (Days)</label>
                                    <input type="number" name="rental_duration_days" id="rental_duration_days"
                                        value="{{ old('rental_duration_days', $book->rental_duration_days ?? 7) }}" min="1"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all"
                                        placeholder="7">
                                    @error('rental_duration_days')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Late Fee -->
                                <div x-show="type === 'rent' || type === 'both'">
                                    <label for="late_fee_per_day"
                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Late Fee
                                        Per Day (₹)</label>
                                    <input type="number" name="late_fee_per_day" id="late_fee_per_day"
                                        value="{{ old('late_fee_per_day', $book->late_fee_per_day ?? 5.00) }}" step="0.01"
                                        min="0"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all"
                                        placeholder="5.00">
                                    @error('late_fee_per_day')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Selling Price -->
                                <div x-show="type === 'sale' || type === 'both'">
                                    <label for="selling_price"
                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Selling
                                        Price (₹)</label>
                                    <input type="number" name="selling_price" id="selling_price"
                                        value="{{ old('selling_price', $book->selling_price) }}" step="0.01" min="0"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all"
                                        placeholder="0.00">
                                    @error('selling_price')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- SEO Settings Card -->
                        <div
                            class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                            <h3
                                class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2 pb-3 border-b border-gray-200 dark:border-gray-700">
                                <span class="material-symbols-outlined text-blue-500">search</span>
                                SEO Optimization
                            </h3>
                            <div class="space-y-4">
                                <!-- Slug -->
                                <div>
                                    <label for="slug"
                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Custom
                                        Slug (URL)</label>
                                    <div class="flex rounded-xl shadow-sm">
                                        <span
                                            class="inline-flex items-center px-4 rounded-l-xl border border-r-0 border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 text-sm">
                                            {{ url('/book') }}/<span
                                                x-text="category ? category.toLowerCase().replace(/[^a-z0-9]+/g, '-') : 'category'"></span>/
                                        </span>
                                        <input type="text" name="slug" id="slug" value="{{ old('slug', $book->slug) }}"
                                            class="flex-1 min-w-0 block w-full px-4 py-3 rounded-none rounded-r-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                            placeholder="book-title">
                                    </div>
                                    <p id="slug-error" class="mt-1 text-sm text-red-600 dark:text-red-400 hidden"></p>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Leave empty to auto-generate
                                        from title.</p>
                                    @error('slug')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Meta Title -->
                                <div>
                                    <label for="meta_title"
                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Meta
                                        Title</label>
                                    <input type="text" name="meta_title" id="meta_title"
                                        value="{{ old('meta_title', $book->meta_title) }}"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                        placeholder="SEO Title">
                                </div>

                                <!-- Meta Description -->
                                <div>
                                    <label for="meta_description"
                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Meta
                                        Description</label>
                                    <textarea name="meta_description" id="meta_description" rows="3"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none"
                                        placeholder="SEO Description">{{ old('meta_description', $book->meta_description) }}</textarea>
                                </div>

                                <!-- Meta Keywords -->
                                <div>
                                    <label for="meta_keywords"
                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Meta
                                        Keywords</label>
                                    <input type="text" name="meta_keywords" id="meta_keywords"
                                        value="{{ old('meta_keywords', $book->meta_keywords) }}"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                        placeholder="keyword1, keyword2, keyword3">
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex gap-4">
                            <button type="submit"
                                class="flex-1 px-6 py-4 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold rounded-xl shadow-lg transition-all transform hover:scale-105 flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined">save</span>
                                Update Book
                            </button>
                            <a href="{{ route('library.admin.books.index') }}"
                                class="px-6 py-4 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-bold rounded-xl transition-all">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewCover(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.getElementById('cover-image') || document.getElementById('cover-image-new');
                    if (img) {
                        img.src = e.target.result;
                        const preview = document.getElementById('cover-preview');
                        const placeholder = document.getElementById('cover-placeholder');
                        if (preview) preview.classList.remove('hidden');
                        if (placeholder) placeholder.classList.add('hidden');
                    }
                }
                reader.readAsDataURL(file);
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const titleInput = document.getElementById('title');
            const categoryInput = document.getElementById('category');
            const slugInput = document.getElementById('slug');
            const slugError = document.getElementById('slug-error');
            const statusInput = document.getElementById('status');
            const quantityInput = document.getElementById('quantity');

            // Handle Status -> Quantity logic
            if (statusInput && quantityInput) {
                function toggleQuantity() {
                    if (statusInput.value === 'lost') {
                        quantityInput.readOnly = true;
                        if (event && event.type === 'change') quantityInput.value = 0;
                        quantityInput.classList.add('bg-gray-100', 'dark:bg-gray-600', 'cursor-not-allowed', 'opacity-70');
                    } else {
                        quantityInput.readOnly = false;
                        quantityInput.classList.remove('bg-gray-100', 'dark:bg-gray-600', 'cursor-not-allowed', 'opacity-70');
                    }
                }

                statusInput.addEventListener('change', toggleQuantity);
                toggleQuantity(); // Run on load
            }

            // If slug exists, we consider it "manual" so we don't auto-update it unless user clears it
            let isManualSlug = slugInput.value.trim() !== '';

            function generateSlug(text) {
                return text.toString().toLowerCase()
                    .replace(/\s+/g, '-')           // Replace spaces with -
                    .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
                    .replace(/\-\-+/g, '-')         // Replace multiple - with single -
                    .replace(/^-+/, '')             // Trim - from start of text
                    .replace(/-+$/, '');            // Trim - from end of text
            }

            // We now only generate slug from TITLE, not category-title, as category is in URL path
            function updateSlug() {
                if (isManualSlug) return;

                const title = titleInput.value;

                if (title) {
                    const slug = generateSlug(`${title}`); // Changed: Only use title
                    slugInput.value = slug;
                    checkSlugAvailability(slug);
                }
            }

            titleInput.addEventListener('input', updateSlug);
            // categoryInput.addEventListener('change', updateSlug); // Category no longer affects slug

            slugInput.addEventListener('input', function () {
                if (this.value.trim() === '') {
                    isManualSlug = false; // Allow auto-generation if cleared
                } else {
                    isManualSlug = true;
                }
                checkSlugAvailability(this.value);
            });

            let checkTimeout;
            function checkSlugAvailability(slug) {
                clearTimeout(checkTimeout);
                slugError.classList.add('hidden');
                slugInput.classList.remove('border-red-500', 'focus:ring-red-500');
                slugInput.classList.add('border-gray-300', 'dark:border-gray-600', 'focus:ring-blue-500');

                if (!slug) return;

                checkTimeout = setTimeout(() => {
                    fetch('{{ route('library.admin.books.checkSlug') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            slug: slug,
                            id: {{ $book->id }} 
                                            })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.exists) {
                                slugError.textContent = "Already this url is in database, change the url";
                                slugError.classList.remove('hidden');
                                slugInput.classList.add('border-red-500', 'focus:ring-red-500');
                                slugInput.classList.remove('border-gray-300', 'dark:border-gray-600', 'focus:ring-blue-500');
                            }
                        });
                }, 500);
            }
        });
    </script>
@endsection