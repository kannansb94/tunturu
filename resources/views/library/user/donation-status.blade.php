@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8 relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 p-8 shadow-2xl">
                <div class="absolute inset-0 bg-black/10"></div>
                <div class="relative z-10 flex items-center gap-4">
                    <div class="p-4 bg-white/20 backdrop-blur-sm rounded-full">
                        <span class="material-symbols-outlined text-5xl text-white">book_online</span>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-white mb-1">My Donation Status</h1>
                        <p class="text-white/90">Track the status of your book donations</p>
                    </div>
                </div>
            </div>

            @if($donations->isEmpty())
                <!-- Empty State -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-12 text-center">
                    <span class="material-symbols-outlined text-6xl text-gray-400 mb-4">library_books</span>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No Donations Yet</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">You haven't donated any books yet. Start sharing knowledge today!</p>
                    <a href="{{ route('library.user.donate') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
                        <span class="material-symbols-outlined">volunteer_activism</span>
                        Donate a Book
                    </a>
                </div>
            @else
                <!-- Donations List -->
                <div class="space-y-4">
                    @foreach($donations as $donation)
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                            <div class="p-6">
                                <div class="flex items-start gap-6">
                                    <!-- Book Cover -->
                                    <div class="flex-shrink-0">
                                        @if($donation->cover_image)
                                            <img src="{{ asset('storage/' . $donation->cover_image) }}" alt="{{ $donation->title }}" class="w-24 h-32 object-cover rounded-lg shadow-md">
                                        @else
                                            <div class="w-24 h-32 bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-700 dark:to-gray-600 rounded-lg flex items-center justify-center">
                                                <span class="material-symbols-outlined text-4xl text-gray-400">book</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Book Details -->
                                    <div class="flex-1">
                                        <div class="flex items-start justify-between mb-3">
                                            <div>
                                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">{{ $donation->title }}</h3>
                                                <p class="text-gray-600 dark:text-gray-400">by {{ $donation->author }}</p>
                                            </div>
                                            
                                            <!-- Status Badge -->
                                            @if($donation->status === 'available')
                                                <span class="px-4 py-2 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200 rounded-full text-sm font-semibold flex items-center gap-2">
                                                    <span class="material-symbols-outlined text-sm">check_circle</span>
                                                    Approved
                                                </span>
                                            @elseif($donation->status === 'pending_approval')
                                                <span class="px-4 py-2 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-200 rounded-full text-sm font-semibold flex items-center gap-2 animate-pulse">
                                                    <span class="material-symbols-outlined text-sm">pending</span>
                                                    Pending
                                                </span>
                                            @elseif($donation->status === 'rejected')
                                                <span class="px-4 py-2 bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-200 rounded-full text-sm font-semibold flex items-center gap-2">
                                                    <span class="material-symbols-outlined text-sm">cancel</span>
                                                    Rejected
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Donation Info -->
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                            <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                                <span class="material-symbols-outlined text-lg">calendar_today</span>
                                                <span>Donated: {{ $donation->created_at->format('M d, Y') }}</span>
                                            </div>

                                            @if($donation->donor_location)
                                                <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                                    <span class="material-symbols-outlined text-lg">location_on</span>
                                                    <span>{{ $donation->donor_location }}</span>
                                                </div>
                                            @endif

                                            @if($donation->approved_at)
                                                <div class="flex items-center gap-2 text-sm text-green-600 dark:text-green-400">
                                                    <span class="material-symbols-outlined text-lg">verified</span>
                                                    <span>Approved: {{ $donation->approved_at->format('M d, Y h:i A') }}</span>
                                                </div>
                                            @endif

                                            @if($donation->rejected_at)
                                                <div class="flex items-center gap-2 text-sm text-red-600 dark:text-red-400">
                                                    <span class="material-symbols-outlined text-lg">cancel</span>
                                                    <span>Rejected: {{ $donation->rejected_at->format('M d, Y h:i A') }}</span>
                                                </div>
                                            @endif

                                            @if($donation->approver)
                                                <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                                    <span class="material-symbols-outlined text-lg">person</span>
                                                    <span>Reviewed by: {{ $donation->approver->name }}</span>
                                                </div>
                                            @endif

                                            @if($donation->status === 'available')
                                                <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                                    <span class="material-symbols-outlined text-lg">category</span>
                                                    <span>Category: {{ $donation->category }}</span>
                                                </div>
                                            @endif
                                        </div>

                                        @if($donation->description)
                                            <div class="mt-4 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                                <p class="text-sm text-gray-700 dark:text-gray-300">{{ $donation->description }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $donations->links() }}
                </div>
            @endif

            <!-- Back Button -->
            <div class="mt-8 text-center">
                <a href="{{ route('library.user') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-semibold rounded-xl transition-all duration-200">
                    <span class="material-symbols-outlined">arrow_back</span>
                    Back to Dashboard
                </a>
            </div>
        </div>
    </div>
@endsection
