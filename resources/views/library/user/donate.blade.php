@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div
                class="mb-8 relative overflow-hidden rounded-2xl bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 p-8 shadow-2xl">
                <div class="absolute inset-0 bg-black/10"></div>
                <div class="relative z-10 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="p-4 bg-white/20 backdrop-blur-sm rounded-full">
                            <span class="material-symbols-outlined text-5xl text-white">volunteer_activism</span>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-white mb-1">Donate a Book</h1>
                            <p class="text-white/90">Share knowledge by donating books to our library</p>
                        </div>
                    </div>
                    <a href="{{ route('library.user.donation.status') }}"
                        class="px-4 py-2 bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white rounded-xl transition-all duration-200 flex items-center gap-2 font-bold whitespace-nowrap hidden sm:flex">
                        <span class="material-symbols-outlined">track_changes</span>
                        Track Donations
                    </a>
                </div>
            </div>

            <!-- Drop-off Information -->
            @if(!empty($settings['donation_address']))
                <div
                    class="bg-blue-50 dark:bg-blue-900/20 border-2 border-blue-200 dark:border-blue-800 rounded-2xl shadow-sm mb-8 overflow-hidden">
                    <div class="p-6 md:p-8 flex items-start gap-4">
                        <div class="p-3 bg-blue-100 dark:bg-blue-800 rounded-full flex-shrink-0">
                            <span
                                class="material-symbols-outlined text-blue-600 dark:text-blue-300 text-3xl">local_shipping</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-blue-900 dark:text-blue-100 mb-2">Where to send your book</h3>
                            <p class="text-blue-800 dark:text-blue-200 mb-4 whitespace-pre-line">
                                {{ $settings['donation_address'] }}
                            </p>

                            @if(!empty($settings['donation_notes']))
                                <div
                                    class="mb-4 p-3 bg-blue-100/50 dark:bg-blue-800/50 rounded-lg border border-blue-200 dark:border-blue-700">
                                    <p class="text-sm text-blue-900 dark:text-blue-100 whitespace-pre-line flex items-start gap-2">
                                        <span class="material-symbols-outlined text-base mt-0.5">info</span>
                                        <span class="flex-1">{{ $settings['donation_notes'] }}</span>
                                    </p>
                                </div>
                            @endif

                            @if(!empty($settings['donation_contact_name']) || !empty($settings['donation_contact_number']))
                                <div
                                    class="flex flex-col sm:flex-row sm:items-center gap-4 text-sm font-medium text-blue-800 dark:text-blue-300">
                                    @if(!empty($settings['donation_contact_name']))
                                        <div class="flex items-center gap-2">
                                            <span class="material-symbols-outlined text-base">person</span>
                                            {{ $settings['donation_contact_name'] }}
                                        </div>
                                    @endif

                                    @if(!empty($settings['donation_contact_number']))
                                        <div class="flex items-center gap-2">
                                            <span class="material-symbols-outlined text-base">call</span>
                                            {{ $settings['donation_contact_number'] }}
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Donation Form Card -->
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-8">
                    <form method="POST" action="{{ route('library.user.donate.store') }}" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf

                        <!-- Book Title -->
                        <div class="group">
                            <label for="title"
                                class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                <span class="material-symbols-outlined text-lg text-green-500">book</span>
                                Book Title
                                <span class="text-xs text-red-500">*</span>
                            </label>
                            <input id="title" name="title" type="text" value="{{ old('title') }}" required
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-green-500 focus:ring-4 focus:ring-green-500/20 transition-all duration-200"
                                placeholder="Enter the book title" />
                            @error('title')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Author -->
                        <div class="group">
                            <label for="author"
                                class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                <span class="material-symbols-outlined text-lg text-green-500">person</span>
                                Author
                                <span class="text-xs text-red-500">*</span>
                            </label>
                            <input id="author" name="author" type="text" value="{{ old('author') }}" required
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-green-500 focus:ring-4 focus:ring-green-500/20 transition-all duration-200"
                                placeholder="Enter the author's name" />
                            @error('author')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- ISBN (Optional) -->
                        <div class="group">
                            <label for="isbn"
                                class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                <span class="material-symbols-outlined text-lg text-green-500">tag</span>
                                ISBN (Optional)
                            </label>
                            <input id="isbn" name="isbn" type="text" value="{{ old('isbn') }}"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-green-500 focus:ring-4 focus:ring-green-500/20 transition-all duration-200"
                                placeholder="978-3-16-148410-0" />
                            @error('isbn')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="group">
                            <label for="description"
                                class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                <span class="material-symbols-outlined text-lg text-green-500">description</span>
                                Description (Optional)
                            </label>
                            <textarea id="description" name="description" rows="4"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-green-500 focus:ring-4 focus:ring-green-500/20 transition-all duration-200 resize-none"
                                placeholder="Brief description of the book, its condition, etc.">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Cover Image -->
                        <div class="group">
                            <label
                                class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                <span class="material-symbols-outlined text-lg text-green-500">image</span>
                                Book Cover Image (Optional)
                            </label>
                            <div class="relative">
                                <input id="cover_image" name="cover_image" type="file" accept=".jpg,.jpeg,.png"
                                    class="block w-full text-sm text-gray-900 dark:text-gray-100 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none focus:border-green-500 focus:ring-4 focus:ring-green-500/20 transition-all duration-200 file:mr-4 file:py-3 file:px-4 file:rounded-l-xl file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 dark:file:bg-green-900/30 dark:file:text-green-300" />
                            </div>
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">JPG or PNG (Max 2MB)</p>
                            @error('cover_image')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Info Box -->
                        <div class="p-4 bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 rounded-r-lg">
                            <div class="flex items-start gap-3">
                                <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">info</span>
                                <div class="text-sm text-blue-800 dark:text-blue-200">
                                    <p class="font-medium mb-1">What happens next?</p>
                                    <ul class="list-disc list-inside space-y-1 text-blue-700 dark:text-blue-300">
                                        <li>Your donation will be reviewed by our admin team</li>
                                        <li>They will categorize the book and set rental/sale options</li>
                                        <li>Once approved, the book will be available in our catalog</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center gap-4 pt-4">
                            <button type="submit"
                                class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 flex items-center gap-2">
                                <span class="material-symbols-outlined">volunteer_activism</span>
                                Submit Donation
                            </button>

                            <a href="{{ route('library.user') }}"
                                class="px-6 py-3 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-semibold rounded-xl transition-all duration-200 flex items-center gap-2">
                                <span class="material-symbols-outlined">arrow_back</span>
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection