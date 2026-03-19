<!DOCTYPE html>
<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>{{ $app_name ?? 'RuralEmpower' }} - Library</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&amp;display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="https://cdn.jsdelivr.net/gh/studio-freight/lenis@1.0.29/bundled/lenis.min.js"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#a855f7",
                        "primary-hover": "#9333ea",
                        "secondary": "#ec4899",
                        "background-dark": "#0a0a0f",
                        "surface-dark": "#1a1a24",
                        "surface-light": "#252535",
                    },
                    fontFamily: {
                        "display": ["Manrope", "sans-serif"]
                    }
                },
            },
        }
    </script>
    <style>
        html {
            scroll-behavior: auto;
            overflow-x: hidden;
        }

        body {
            overflow-x: hidden;
        }

        .glass {
            background: rgba(26, 26, 36, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            transform: translateZ(0);
            will-change: transform;
        }

        .gradient-text {
            background: linear-gradient(135deg, #a855f7 0%, #ec4899 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .book-card {
            opacity: 0;
            animation: fadeInUp 0.5s ease-out forwards;
            transform: translateZ(0);
            backface-visibility: hidden;
        }

        .book-card:nth-child(1) {
            animation-delay: 0.05s;
        }

        .book-card:nth-child(2) {
            animation-delay: 0.1s;
        }

        .book-card:nth-child(3) {
            animation-delay: 0.15s;
        }

        .book-card:nth-child(4) {
            animation-delay: 0.2s;
        }

        .book-card:nth-child(5) {
            animation-delay: 0.25s;
        }

        .book-card:nth-child(6) {
            animation-delay: 0.3s;
        }

        .book-card:nth-child(7) {
            animation-delay: 0.35s;
        }

        .book-card:nth-child(8) {
            animation-delay: 0.4s;
        }

        .book-card:nth-child(9) {
            animation-delay: 0.45s;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px) translateZ(0);
            }

            100% {
                opacity: 1;
                transform: translateY(0) translateZ(0);
            }
        }

        .sidebar-scrollbar {
            transform: translateZ(0);
        }

        .sidebar-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
        }

        .sidebar-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(168, 85, 247, 0.5);
            border-radius: 10px;
        }

        .sidebar-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(168, 85, 247, 0.7);
        }

        /* Performance optimizations */
        * {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        img {
            transform: translateZ(0);
            backface-visibility: hidden;
        }
    </style>
</head>

<body class="bg-background-dark text-white font-display antialiased">

    <!-- Top Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 glass border-b border-white/10">
        <div class="max-w-full px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-8">
                    <a href="{{ url('/') }}" class="flex items-center gap-2">
                        <x-application-logo class="flex items-center justify-center text-primary" />
                    </a>
                    <div class="hidden md:flex items-center gap-6">
                        <a class="text-gray-400 hover:text-white text-sm font-semibold transition-colors"
                            href="{{ url('/') }}#mission">About</a>
                        <a class="text-gray-400 hover:text-white text-sm font-semibold transition-colors"
                            href="{{ url('/') }}#focus">Focus</a>
                        <a class="text-primary font-bold text-sm" href="{{ route('library.index') }}">Library</a>
                        <a class="text-gray-400 hover:text-white text-sm font-semibold transition-colors"
                            href="{{ url('/') }}#news">News</a>
                    </div>
                </div>

                <!-- Search Bar (Desktop) -->
                <div class="hidden lg:flex flex-1 max-w-xl mx-8">
                    <div class="relative w-full">
                        <span
                            class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xl">search</span>
                        <input type="text" id="topSearch" placeholder="Search books, authors, categories..."
                            class="w-full pl-12 pr-4 py-2.5 bg-surface-dark text-white placeholder-gray-400 rounded-xl border border-white/10 focus:border-primary/50 focus:outline-none text-sm transition-all" />
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('library.cart.index') }}"
                                class="relative text-gray-400 hover:text-white transition-colors p-2" title="Shopping Cart">
                                <span class="material-symbols-outlined text-[24px]">shopping_cart</span>
                                @php
                                    $cartCount = \App\Models\Cart::where('user_id', Auth::id())->count();
                                @endphp
                                @if($cartCount > 0)
                                    <span
                                        class="absolute top-0 right-0 h-4 w-4 bg-primary text-[10px] font-bold text-white flex items-center justify-center rounded-full">{{ $cartCount }}</span>
                                @endif
                            </a>
                            <a href="{{ url('/dashboard') }}"
                                class="text-sm text-gray-400 font-bold hover:text-white transition-colors">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}"
                                class="text-sm text-gray-400 font-semibold hover:text-white transition-colors">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="px-4 py-2 bg-gradient-to-r from-primary to-secondary text-white text-sm font-bold rounded-xl hover:shadow-lg hover:shadow-primary/30 transition-all">Register</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Container with Sidebar -->
    <div class="flex pt-16 min-h-screen">

        <!-- Sidebar Filter Panel -->
        <aside id="sidebar" data-lenis-prevent
            class="hidden lg:block fixed left-0 top-16 bottom-0 w-80 glass border-r border-white/10 overflow-y-auto sidebar-scrollbar">
            <div class="p-6 space-y-6">

                <!-- Filter Header -->
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-black text-white">Filters</h3>
                    <button class="text-xs text-primary hover:text-primary-hover font-bold transition-colors">Clear
                        All</button>
                </div>

                <!-- Categories -->
                <div class="space-y-3">
                    <button
                        class="w-full text-left px-4 py-2.5 bg-surface-dark rounded-xl border border-white/10 hover:border-primary/50 transition-all flex items-center justify-between group">
                        <span class="text-sm font-bold text-white">Categories</span>
                        <span
                            class="material-symbols-outlined text-gray-400 group-hover:text-primary transition-colors">expand_more</span>
                    </button>
                    <div class="space-y-2 pl-2">
                        @foreach($categories as $category)
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox"
                                    class="w-4 h-4 rounded border-gray-600 text-primary focus:ring-primary focus:ring-offset-0">
                                <span
                                    class="text-sm text-gray-300 group-hover:text-white transition-colors">{{ $category->name }}</span>
                                <span
                                    class="ml-auto text-xs text-gray-500">{{ $books->where('category', $category->name)->count() }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Price Range -->
                <div class="space-y-3">
                    <button
                        class="w-full text-left px-4 py-2.5 bg-surface-dark rounded-xl border border-white/10 hover:border-primary/50 transition-all flex items-center justify-between group">
                        <span class="text-sm font-bold text-white">Price Range</span>
                        <span
                            class="material-symbols-outlined text-gray-400 group-hover:text-primary transition-colors">expand_more</span>
                    </button>
                    <div class="space-y-4 px-2">
                        <div class="flex gap-3">
                            <input type="number" placeholder="Min"
                                class="w-1/2 px-3 py-2 bg-surface-dark text-white text-sm rounded-lg border border-white/10 focus:border-primary/50 focus:outline-none">
                            <input type="number" placeholder="Max"
                                class="w-1/2 px-3 py-2 bg-surface-dark text-white text-sm rounded-lg border border-white/10 focus:border-primary/50 focus:outline-none">
                        </div>
                    </div>
                </div>

                <!-- Availability -->
                <div class="space-y-3">
                    <button
                        class="w-full text-left px-4 py-2.5 bg-surface-dark rounded-xl border border-white/10 hover:border-primary/50 transition-all flex items-center justify-between group">
                        <span class="text-sm font-bold text-white">Availability</span>
                        <span
                            class="material-symbols-outlined text-gray-400 group-hover:text-primary transition-colors">expand_more</span>
                    </button>
                    <div class="space-y-2 pl-2">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox"
                                class="w-4 h-4 rounded border-gray-600 text-primary focus:ring-primary focus:ring-offset-0">
                            <span class="text-sm text-gray-300 group-hover:text-white transition-colors">For Rent</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox"
                                class="w-4 h-4 rounded border-gray-600 text-primary focus:ring-primary focus:ring-offset-0">
                            <span class="text-sm text-gray-300 group-hover:text-white transition-colors">For Sale</span>
                        </label>
                    </div>
                </div>

                <!-- Rating -->
                <div class="space-y-3">
                    <button
                        class="w-full text-left px-4 py-2.5 bg-surface-dark rounded-xl border border-white/10 hover:border-primary/50 transition-all flex items-center justify-between group">
                        <span class="text-sm font-bold text-white">Rating</span>
                        <span
                            class="material-symbols-outlined text-gray-400 group-hover:text-primary transition-colors">expand_more</span>
                    </button>
                    <div class="space-y-2 pl-2">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="checkbox"
                                class="w-4 h-4 rounded border-gray-600 text-primary focus:ring-primary focus:ring-offset-0">
                            <div class="flex gap-0.5">
                                <span class="material-symbols-outlined text-amber-400 text-sm">star</span>
                                <span class="material-symbols-outlined text-amber-400 text-sm">star</span>
                                <span class="material-symbols-outlined text-amber-400 text-sm">star</span>
                                <span class="material-symbols-outlined text-amber-400 text-sm">star</span>
                                <span class="material-symbols-outlined text-amber-400 text-sm">star</span>
                            </div>
                            <span class="text-xs text-gray-400">& up</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="checkbox"
                                class="w-4 h-4 rounded border-gray-600 text-primary focus:ring-primary focus:ring-offset-0">
                            <div class="flex gap-0.5">
                                <span class="material-symbols-outlined text-amber-400 text-sm">star</span>
                                <span class="material-symbols-outlined text-amber-400 text-sm">star</span>
                                <span class="material-symbols-outlined text-amber-400 text-sm">star</span>
                                <span class="material-symbols-outlined text-amber-400 text-sm">star</span>
                                <span class="material-symbols-outlined text-gray-600 text-sm">star</span>
                            </div>
                            <span class="text-xs text-gray-400">& up</span>
                        </label>
                    </div>
                </div>

            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 lg:ml-80 min-h-screen">

            <!-- Hero Section -->
            <section class="relative px-6 lg:px-12 py-12 border-b border-white/5">
                <div class="max-w-7xl mx-auto">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                        <div>
                            <h1 class="text-4xl md:text-5xl font-black mb-3">
                                Explore <span class="gradient-text">Knowledge</span>
                            </h1>
                            <p class="text-gray-400 text-lg">Discover, learn, and grow with our curated collection</p>
                        </div>

                        <!-- Quick Stats -->
                        <div class="flex gap-6">
                            <div class="text-center">
                                <div class="text-3xl font-black gradient-text">{{ $books->count() }}</div>
                                <div class="text-xs text-gray-500 uppercase tracking-wider mt-1">Books</div>
                            </div>
                            <div class="h-12 w-px bg-white/10"></div>
                            <div class="text-center">
                                <div class="text-3xl font-black gradient-text">12</div>
                                <div class="text-xs text-gray-500 uppercase tracking-wider mt-1">Categories</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Toolbar -->
            <section class="sticky top-16 z-40 glass border-b border-white/10 px-6 lg:px-12 py-4">
                <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-4">

                    <!-- Mobile Filter Toggle -->
                    <button id="mobileFilterToggle"
                        class="lg:hidden px-4 py-2 bg-surface-dark rounded-xl border border-white/10 hover:border-primary/50 transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined text-xl">tune</span>
                        <span class="text-sm font-bold">Filters</span>
                    </button>

                    <!-- View Mode Toggle -->
                    <div class="flex items-center gap-2 bg-surface-dark rounded-xl p-1 border border-white/10">
                        <button id="gridViewBtn"
                            class="px-3 py-2 bg-primary text-white rounded-lg transition-all flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-lg">grid_view</span>
                            <span class="text-xs font-bold hidden sm:inline">Grid</span>
                        </button>
                        <button id="listViewBtn"
                            class="px-3 py-2 text-gray-400 hover:text-white rounded-lg transition-all flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-lg">view_list</span>
                            <span class="text-xs font-bold hidden sm:inline">List</span>
                        </button>
                    </div>

                    <!-- Sort Dropdown -->
                    <div class="relative">
                        <select
                            class="px-4 py-2.5 bg-surface-dark text-white text-sm font-semibold rounded-xl border border-white/10 focus:border-primary/50 focus:outline-none appearance-none pr-10 cursor-pointer">
                            <option>Sort: Newest</option>
                            <option>Sort: Popular</option>
                            <option>Sort: Price Low-High</option>
                            <option>Sort: Price High-Low</option>
                            <option>Sort: Rating</option>
                        </select>
                        <span
                            class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">expand_more</span>
                    </div>

                    <!-- Results Count -->
                    <div class="text-sm text-gray-400">
                        Showing <span class="text-white font-bold">{{ $books->count() }}</span> results
                    </div>
                </div>
            </section>

            <!-- Books Grid -->
            <section class="px-2 md:px-6 lg:px-12 py-8">
                <div class="max-w-7xl mx-auto">
                    @if($books->isEmpty())
                        <div class="p-20 text-center glass rounded-3xl border border-white/10">
                            <span
                                class="material-symbols-outlined text-8xl text-primary mb-6 inline-block">library_books</span>
                            <h3 class="text-2xl font-bold text-white mb-2">No Books Available</h3>
                            <p class="text-gray-400 text-lg">Check back soon for new additions</p>
                        </div>
                    @else
                        <div id="booksGrid"
                            class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-3 md:gap-6">
                            @foreach($books as $book)
                                @php
                                    $catObj = $categories->firstWhere('name', $book->category);
                                    $realCategorySlug = $catObj ? $catObj->slug : Str::slug($book->category ?? 'general');
                                @endphp
                                <div class="book-card group relative" data-book-id="{{ $book->id }}"
                                    data-category="{{ $book->category ?? 'General' }}"
                                    data-category-slug="{{ $realCategorySlug }}"
                                    data-rent-price="{{ $book->rental_price ?? 0 }}"
                                    data-sale-price="{{ $book->selling_price ?? 0 }}" data-type="{{ $book->type }}"
                                    data-book-slug="{{ $book->slug ?? $book->id }}">
                                    <div
                                        class="bg-surface-dark rounded-xl md:rounded-2xl overflow-hidden border border-white/10 hover:border-primary/50 transition-all duration-500 hover:shadow-2xl hover:shadow-primary/20 flex flex-col h-full hover:-translate-y-1">

                                        <!-- Image -->
                                        <div
                                            class="relative aspect-[3/4] md:aspect-square overflow-hidden bg-gradient-to-br from-surface-light to-surface-dark">
                                            @if($book->cover_image)
                                                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}"
                                                    class="w-full h-full object-cover transition-all duration-500 group-hover:scale-105">
                                            @else
                                                <div class="w-full h-full flex flex-col items-center justify-center text-gray-600">
                                                    <span
                                                        class="material-symbols-outlined text-4xl md:text-7xl mb-1 md:mb-3 transition-transform group-hover:scale-110 duration-500 text-primary">auto_stories</span>
                                                    <span
                                                        class="text-[10px] md:text-xs uppercase tracking-widest opacity-60 font-bold hidden md:block">{{ $book->category ?? 'Book' }}</span>
                                                </div>
                                            @endif

                                            <!-- Overlay -->
                                            <div
                                                class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                            </div>

                                            <!-- Badges -->
                                            <div
                                                class="absolute top-2 left-2 right-2 md:top-3 md:left-3 md:right-3 flex justify-between items-start gap-2 z-10">
                                                <span
                                                    class="hidden md:inline-block px-3 py-1.5 bg-gradient-to-r from-primary/90 to-secondary/90 backdrop-blur-md text-white text-xs font-black uppercase tracking-wide rounded-full">
                                                    {{ $book->category ?? 'General' }}
                                                </span>
                                                <button
                                                    class="p-1 md:p-1.5 bg-black/40 backdrop-blur-md rounded-full hover:bg-black/60 transition-all ml-auto">
                                                    <span
                                                        class="material-symbols-outlined text-white text-sm md:text-lg">favorite</span>
                                                </button>
                                            </div>

                                            <!-- Quick View -->
                                            <div
                                                class="absolute bottom-0 left-0 right-0 p-3 translate-y-full group-hover:translate-y-0 transition-transform duration-500 hidden md:block">
                                                <button
                                                    class="quick-view-btn w-full py-2.5 bg-white text-gray-900 font-bold rounded-xl hover:bg-primary hover:text-white transition-all flex items-center justify-center gap-2">
                                                    <span class="material-symbols-outlined text-lg">visibility</span>
                                                    <span class="text-sm">Quick View</span>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Content -->
                                        <div class="p-2 md:p-4 flex flex-col flex-grow">
                                            <h3 class="text-white font-bold text-xs md:text-base mb-1 leading-tight line-clamp-2 group-hover:text-primary transition-colors"
                                                title="{{ $book->title }}">
                                                {{ $book->title }}
                                            </h3>
                                            <p
                                                class="text-gray-400 text-[10px] md:text-sm font-medium mb-1 md:mb-3 line-clamp-1">
                                                {{ $book->author }}
                                            </p>

                                            <!-- Rating -->
                                            <div class="hidden md:flex items-center gap-1 mb-4">
                                                @for ($i = 0; $i < 5; $i++)
                                                    <span class="material-symbols-outlined text-amber-400 text-sm">star</span>
                                                @endfor
                                                <span class="text-xs text-gray-500 ml-1">4.5</span>
                                            </div>

                                            <!-- Prices -->
                                            <div class="mt-auto grid grid-cols-1 gap-1 md:grid-cols-2 md:gap-3 mb-2 md:mb-3">
                                                @if($book->type == 'rent' || $book->type == 'both')
                                                    <div>
                                                        <div
                                                            class="hidden md:block text-[10px] text-gray-500 uppercase tracking-wider font-bold mb-0.5">
                                                            Rent/Mo</div>
                                                        <div class="text-primary font-bold text-xs md:font-black md:text-lg">
                                                            ₹{{ number_format($book->rental_price, 0) }}</div>
                                                    </div>
                                                @endif

                                                @if($book->type == 'sale' || $book->type == 'both')
                                                    <div class="md:text-right">
                                                        <div
                                                            class="hidden md:block text-[10px] text-gray-500 uppercase tracking-wider font-bold mb-0.5">
                                                            Buy</div>
                                                        <div class="text-secondary font-bold text-xs md:font-black md:text-lg">
                                                            ₹{{ number_format($book->selling_price, 0) }}</div>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Buttons -->
                                            <div class="grid grid-cols-1 gap-1.5 md:grid-cols-2 md:gap-2">
                                                @if($book->type == 'rent' || $book->type == 'both')
                                                    @if($book->quantity > 0)
                                                        @auth
                                                            <form action="{{ route('library.cart.add') }}" method="POST" class="w-full">
                                                                @csrf
                                                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                                                <input type="hidden" name="action" value="rent">
                                                                <button type="submit"
                                                                    class="w-full py-1.5 px-2 md:py-2.5 md:px-3 rounded-lg md:rounded-xl bg-gradient-to-r from-primary to-primary-hover text-white font-bold text-[10px] md:text-xs hover:shadow-lg hover:shadow-primary/40 transition-all flex items-center justify-center gap-1">
                                                                    <span>Rent</span>
                                                                    <span
                                                                        class="material-symbols-outlined text-[10px] md:text-sm hidden md:inline">key</span>
                                                                </button>
                                                            </form>
                                                        @else
                                                            <a href="{{ route('login') }}"
                                                                class="w-full py-1.5 px-2 md:py-2.5 md:px-3 rounded-lg md:rounded-xl bg-gradient-to-r from-primary to-primary-hover text-white font-bold text-[10px] md:text-xs hover:shadow-lg hover:shadow-primary/40 transition-all flex items-center justify-center gap-1">
                                                                <span>Rent</span>
                                                            </a>
                                                        @endauth
                                                    @else
                                                        <button disabled
                                                            class="w-full py-1.5 px-2 md:py-2.5 md:px-3 rounded-lg md:rounded-xl bg-surface-light border border-white/10 text-gray-500 font-bold text-[10px] md:text-xs cursor-not-allowed flex items-center justify-center gap-1">
                                                            <span>Rented Out</span>
                                                            <span
                                                                class="material-symbols-outlined text-[10px] md:text-sm hidden md:inline">key_off</span>
                                                        </button>
                                                    @endif
                                                @endif

                                                @if($book->type == 'sale' || $book->type == 'both')
                                                    @if($book->quantity > 0)
                                                        @auth
                                                            <form action="{{ route('library.cart.add') }}" method="POST" class="w-full">
                                                                @csrf
                                                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                                                <input type="hidden" name="action" value="buy">
                                                                <button type="submit"
                                                                    class="w-full py-1.5 px-2 md:py-2.5 md:px-3 rounded-lg md:rounded-xl bg-gradient-to-r from-secondary to-pink-600 text-white font-bold text-[10px] md:text-xs hover:shadow-lg hover:shadow-secondary/40 transition-all flex items-center justify-center gap-1">
                                                                    <span>Buy</span>
                                                                    <span
                                                                        class="material-symbols-outlined text-[10px] md:text-sm hidden md:inline">shopping_bag</span>
                                                                </button>
                                                            </form>
                                                        @else
                                                            <a href="{{ route('login') }}"
                                                                class="w-full py-1.5 px-2 md:py-2.5 md:px-3 rounded-lg md:rounded-xl bg-gradient-to-r from-secondary to-pink-600 text-white font-bold text-[10px] md:text-xs hover:shadow-lg hover:shadow-secondary/40 transition-all flex items-center justify-center gap-1">
                                                                <span>Buy</span>
                                                            </a>
                                                        @endauth
                                                    @else
                                                        <button disabled
                                                            class="w-full py-1.5 px-2 md:py-2.5 md:px-3 rounded-lg md:rounded-xl bg-surface-light border border-white/10 text-gray-500 font-bold text-[10px] md:text-xs cursor-not-allowed flex items-center justify-center gap-1">
                                                            <span>Sold Out</span>
                                                            <span
                                                                class="material-symbols-outlined text-[10px] md:text-sm hidden md:inline">production_quantity_limits</span>
                                                        </button>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>

        </main>
    </div>

    <!-- Back to Top Button -->
    <button id="backToTop"
        class="fixed bottom-8 right-8 p-4 bg-gradient-to-r from-primary to-secondary text-white rounded-full shadow-2xl hover:shadow-primary/50 transition-all opacity-0 pointer-events-none z-50">
        <span class="material-symbols-outlined">arrow_upward</span>
    </button>

    <script>
        // Initialize Lenis Smooth Scroll with optimized settings
        const lenis = new Lenis({
            duration: 1.0,
            easing: (t) => (t === 1 ? 1 : 1 - Math.pow(2, -10 * t)),
            direction: 'vertical',
            gestureDirection: 'vertical',
            smooth: true,
            mouseMultiplier: 0.8,
            smoothTouch: false,
            touchMultiplier: 1.5,
            infinite: false,
            syncTouch: false,
            syncTouchLerp: 0.1,
        });

        function raf(time) {
            lenis.raf(time);
            requestAnimationFrame(raf);
        }

        requestAnimationFrame(raf);

        // Stop Lenis on sidebar scroll
        const sidebar = document.getElementById('sidebar');
        if (sidebar) {
            sidebar.addEventListener('wheel', (e) => {
                e.stopPropagation();
            }, { passive: false });
        }

        // Back to top button
        const backToTop = document.getElementById('backToTop');
        lenis.on('scroll', ({ scroll }) => {
            if (scroll > 300) {
                backToTop.classList.remove('opacity-0', 'pointer-events-none');
            } else {
                backToTop.classList.add('opacity-0', 'pointer-events-none');
            }
        });

        backToTop.addEventListener('click', () => {
            lenis.scrollTo(0, { duration: 1.2 });
        });

        // ==================== UI STATE MANAGEMENT ====================
        // sidebar is defined above (line 589)
        const mobileFilterBtn = document.getElementById('mobileFilterToggle');
        const closeSidebarBtn = document.createElement('button');

        // Setup Mobile Sidebar
        function setupMobileSidebar() {
            if (!sidebar) return;

            // Add close button to sidebar if not exists
            if (!sidebar.querySelector('.sidebar-close-btn')) {
                const p6 = sidebar.querySelector('.p-6');
                if (p6) {
                    closeSidebarBtn.className = 'sidebar-close-btn absolute top-4 right-4 p-2 text-gray-400 hover:text-white lg:hidden';
                    closeSidebarBtn.innerHTML = '<span class="material-symbols-outlined">close</span>';
                    p6.prepend(closeSidebarBtn);

                    closeSidebarBtn.addEventListener('click', () => {
                        sidebar.classList.add('hidden');
                        sidebar.classList.remove('fixed', 'inset-0', 'z-50', 'bg-surface-dark', 'w-full');
                        document.body.style.overflow = ''; // Restore scrolling
                    });
                }
            }

            // Mobile Filter Button Click
            if (mobileFilterBtn) {
                mobileFilterBtn.addEventListener('click', () => {
                    sidebar.classList.remove('hidden');
                    sidebar.classList.add('fixed', 'inset-0', 'z-50', 'bg-surface-dark', 'w-full');
                    document.body.style.overflow = 'hidden'; // Prevent background scrolling
                });
            }
        }

        setupMobileSidebar();

        setupMobileSidebar();

        // View Mode Toggle
        const gridBtn = document.getElementById('gridViewBtn');
        const listBtn = document.getElementById('listViewBtn');

        const booksGrid = document.getElementById('booksGrid');
        const bookCards = document.querySelectorAll('.book-card');

        function setView(mode) {
            if (!booksGrid) return;
            if (mode === 'grid') {
                booksGrid.className = 'grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-3 md:gap-6';
                bookCards.forEach(card => {
                    const inner = card.querySelector('.bg-surface-dark');
                    // Mobile: rounded-xl, Desktop: rounded-2xl
                    inner.className = 'bg-surface-dark rounded-xl md:rounded-2xl overflow-hidden border border-white/10 hover:border-primary/50 transition-all duration-500 hover:shadow-2xl hover:shadow-primary/20 flex flex-col h-full hover:-translate-y-1';

                    // Reset Image container
                    const imgContainer = card.querySelector('[class*="aspect-"]');
                    if (imgContainer) imgContainer.className = 'relative aspect-[3/4] md:aspect-square overflow-hidden bg-gradient-to-br from-surface-light to-surface-dark';

                    // Reset Content padding
                    const content = card.querySelector('[class*="p-"]');
                    if (content) content.className = 'p-2 md:p-4 flex flex-col flex-grow';
                });

                if (gridBtn) {
                    gridBtn.classList.add('bg-primary', 'text-white');
                    gridBtn.classList.remove('text-gray-400', 'hover:text-white');
                }
                if (listBtn) {
                    listBtn.classList.remove('bg-primary', 'text-white');
                    listBtn.classList.add('text-gray-400', 'hover:text-white');
                }
            } else {
                booksGrid.className = 'flex flex-col gap-4';
                bookCards.forEach(card => {
                    const inner = card.querySelector('.bg-surface-dark');
                    inner.className = 'bg-surface-dark rounded-xl md:rounded-2xl overflow-hidden border border-white/10 hover:border-primary/50 transition-all duration-500 hover:shadow-2xl hover:shadow-primary/20 flex flex-row h-auto hover:-translate-x-1';

                    // Adjust Image container for list view
                    const imgContainer = card.querySelector('[class*="aspect-"]');
                    if (imgContainer) imgContainer.className = 'relative w-24 md:w-48 shrink-0 overflow-hidden bg-gradient-to-br from-surface-light to-surface-dark';

                    // Adjust Content padding
                    const content = card.querySelector('[class*="p-"]');
                    // We need to ensure the content takes remaining width and buttons don't break layout
                    if (content) content.className = 'p-3 md:p-4 flex flex-col flex-grow justify-between';
                });

                if (listBtn) {
                    listBtn.classList.add('bg-primary', 'text-white');
                    listBtn.classList.remove('text-gray-400', 'hover:text-white');
                }
                if (gridBtn) {
                    gridBtn.classList.remove('bg-primary', 'text-white');
                    gridBtn.classList.add('text-gray-400', 'hover:text-white');
                }
            }
        }

        if (gridBtn && listBtn) {
            gridBtn.addEventListener('click', () => setView('grid'));
            listBtn.addEventListener('click', () => setView('list'));
        }

        // ==================== FILTER SYSTEM ====================
        let activeFilters = {
            categories: [],
            minPrice: null,
            maxPrice: null,
            availability: [],
            minRating: 0,
            searchTerm: ''
        };

        function applyFilters() {
            const bookCards = document.querySelectorAll('.book-card');
            let visibleCount = 0;

            bookCards.forEach(card => {
                const category = card.dataset.category?.toLowerCase() || '';
                const rentPrice = parseFloat(card.dataset.rentPrice) || 0;
                const salePrice = parseFloat(card.dataset.salePrice) || 0;
                const type = card.dataset.type || '';
                const title = card.querySelector('h3')?.textContent.toLowerCase() || '';
                const author = card.querySelector('p')?.textContent.toLowerCase() || '';

                let shouldShow = true;

                // Category filter
                if (activeFilters.categories.length > 0) {
                    shouldShow = shouldShow && activeFilters.categories.some(cat => category.includes(cat));
                }

                // Price filter
                if (activeFilters.minPrice || activeFilters.maxPrice) {
                    const price = rentPrice || salePrice;
                    if (activeFilters.minPrice && price < activeFilters.minPrice) shouldShow = false;
                    if (activeFilters.maxPrice && price > activeFilters.maxPrice) shouldShow = false;
                }

                // Availability filter
                if (activeFilters.availability.length > 0) {
                    shouldShow = shouldShow && activeFilters.availability.includes(type);
                }

                // Search filter
                if (activeFilters.searchTerm) {
                    shouldShow = shouldShow && (title.includes(activeFilters.searchTerm) || author.includes(activeFilters.searchTerm));
                }

                if (shouldShow) {
                    card.style.display = '';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Update results count
            const resultsCount = document.querySelector('.text-sm.text-gray-400 span');
            if (resultsCount) {
                resultsCount.textContent = visibleCount;
            }
        }

        // Category checkboxes
        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                const parent = this.closest('label');
                const categoryText = parent?.querySelector('span')?.textContent.toLowerCase();

                if (categoryText && !categoryText.includes('rent') && !categoryText.includes('sale') && !categoryText.includes('star')) {
                    if (this.checked) {
                        activeFilters.categories.push(categoryText);
                    } else {
                        activeFilters.categories = activeFilters.categories.filter(c => c !== categoryText);
                    }
                    applyFilters();
                }
            });
        });

        // Availability filters
        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                const parent = this.closest('label');
                const text = parent?.querySelector('span')?.textContent.toLowerCase();

                if (text?.includes('rent')) {
                    if (this.checked) {
                        activeFilters.availability.push('rent', 'both');
                    } else {
                        activeFilters.availability = activeFilters.availability.filter(t => t !== 'rent' && t !== 'both');
                    }
                    applyFilters();
                } else if (text?.includes('sale')) {
                    if (this.checked) {
                        activeFilters.availability.push('sale', 'both');
                    } else {
                        activeFilters.availability = activeFilters.availability.filter(t => t !== 'sale' && t !== 'both');
                    }
                    applyFilters();
                }
            });
        });

        // Price range inputs
        document.querySelectorAll('input[type="number"]').forEach(input => {
            input.addEventListener('input', function () {
                const isMin = this.placeholder.toLowerCase().includes('min');
                const value = parseFloat(this.value);

                if (isMin) {
                    activeFilters.minPrice = value || null;
                } else {
                    activeFilters.maxPrice = value || null;
                }
                applyFilters();
            });
        });

        // Clear all filters
        document.querySelector('.text-xs.text-primary')?.addEventListener('click', function () {
            activeFilters = {
                categories: [],
                minPrice: null,
                maxPrice: null,
                availability: [],
                minRating: 0,
                searchTerm: ''
            };

            // Reset all checkboxes and inputs
            document.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
            document.querySelectorAll('input[type="number"]').forEach(input => input.value = '');
            document.getElementById('topSearch').value = '';

            applyFilters();
        });

        // Search functionality
        const topSearch = document.getElementById('topSearch');
        topSearch.addEventListener('input', function (e) {
            activeFilters.searchTerm = e.target.value.toLowerCase();
            applyFilters();
        });

        // ==================== BOOK DETAIL & CART ACTIONS ====================

        // Quick View buttons - redirect to detail page
        document.querySelectorAll('.book-card').forEach(card => {
            const quickViewBtn = card.querySelector('.quick-view-btn');
            const bookId = card.dataset.bookId;

            if (quickViewBtn && bookId) {
                quickViewBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    // We need the slug, not the ID. In a real app we'd pass slug in data attribute.
                    // For now, let's assume the ID route works as fallback or update the dataset.

                    const slug = card.dataset.bookSlug || bookId;
                    const category = card.dataset.categorySlug || 'general';
                    const baseUrl = "{{ url('library/book') }}";
                    window.location.href = `${baseUrl}/${category}/${slug}`;
                });
            }

            // Make card title clickable
            const title = card.querySelector('h3');
            if (title && bookId) {
                title.style.cursor = 'pointer';
                title.addEventListener('click', () => {
                    const slug = card.dataset.bookSlug || bookId;
                    const category = card.dataset.categorySlug || 'general';
                    const baseUrl = "{{ url('library/book') }}";
                    window.location.href = `${baseUrl}/${category}/${slug}`;
                });
            }
        });


        // ==================== AUTH & PROFILE CHECKS ====================
        const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
        const missingFields = @json($missingFields ?? []);

        // Authenticated User Logic
        // We'll use simple custom modals tailored to the design
        // Create Modals in DOM
        const modalsHTML = `
            <!-- Auth Modal -->
            <div id="authModal" class="fixed inset-0 z-[60] hidden">
                <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeModal('authModal')"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md bg-surface-dark border border-white/10 rounded-2xl p-6 shadow-2xl transform transition-all scale-100">
                    <div class="text-center">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-primary/10 mb-4">
                            <span class="material-symbols-outlined text-primary text-2xl">lock</span>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">Authentication Required</h3>
                        <p class="text-gray-400 text-sm mb-6">Please log in or register to rent or buy books.</p>
                        <div class="flex gap-3">
                            <a href="{{ route('login') }}" class="flex-1 py-2.5 bg-surface-light hover:bg-white/10 text-white font-bold rounded-xl border border-white/10 transition-all text-sm">Log In</a>
                            <a href="{{ route('register') }}" class="flex-1 py-2.5 bg-gradient-to-r from-primary to-secondary text-white font-bold rounded-xl hover:shadow-lg hover:shadow-primary/30 transition-all text-sm">Register</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Completion Modal -->
            <div id="profileModal" class="fixed inset-0 z-[60] hidden">
                <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeModal('profileModal')"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md bg-white dark:bg-surface-dark border border-gray-200 dark:border-white/10 rounded-2xl p-6 shadow-2xl transform transition-all scale-100">
                    <div class="text-center">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-orange-100 dark:bg-orange-500/10 mb-4">
                            <span class="material-symbols-outlined text-orange-600 dark:text-orange-500 text-2xl">warning</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Incomplete Profile</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">You missed the following mandatory fields in your profile page:</p>
                        
                        <ul class="text-left bg-gray-50 dark:bg-black/20 rounded-xl p-4 mb-6 space-y-2">
                            ${missingFields.map(field => `
                                <li class="flex items-center gap-2 text-sm text-red-600 dark:text-red-400">
                                    <span class="material-symbols-outlined text-lg">error</span>
                                    ${field}
                                </li>
                            `).join('')}
                        </ul>

                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-6">Please fill these details to continue.</p>

                        <a href="{{ route('profile.edit') }}" class="block w-full py-2.5 bg-primary hover:bg-primary-hover text-white font-bold rounded-xl shadow-lg hover:shadow-primary/30 transition-all text-sm">
                            Go to Profile
                        </a>
                    </div>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', modalsHTML);

        window.openModal = function (id) {
            document.getElementById(id).classList.remove('hidden');
        }

        window.closeModal = function (id) {
            document.getElementById(id).classList.add('hidden');
        }

        function checkRequirements() {
            if (!isLoggedIn) {
                openModal('authModal');
                return false;
            }
            return true;
        }


    </script>

</body>

</html>