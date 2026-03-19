<!DOCTYPE html>
<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>{{ $book->meta_title ?? $book->title }} - Library</title>
    <meta name="description" content="{{ $book->meta_description ?? '' }}">
    <meta name="keywords" content="{{ $book->meta_keywords ?? '' }}">

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

    <div class="min-h-screen bg-background-dark text-white font-display antialiased py-24">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            <!-- Breadcrumb -->
            <nav class="flex items-center gap-2 text-sm text-gray-400 mb-8">
                <a href="{{ route('library.index') }}" class="hover:text-primary transition-colors">Library</a>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <span class="text-white font-semibold">{{ $book->title }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                <!-- Left Column: Image -->
                <div class="lg:col-span-4 space-y-6">
                    <div
                        class="aspect-[3/4] rounded-2xl overflow-hidden bg-surface-dark border border-white/10 relative group">
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-gray-600">
                                <span class="material-symbols-outlined text-8xl mb-4 text-primary">auto_stories</span>
                                <span
                                    class="text-sm uppercase tracking-widest opacity-60 font-bold">{{ $book->category ?? 'Book' }}</span>
                            </div>
                        @endif
                    </div>

                    @if($book->images && $book->images->count() > 0)
                        <div class="grid grid-cols-4 gap-4">
                            @foreach($book->images as $image)
                                <div
                                    class="aspect-square rounded-xl overflow-hidden border border-white/10 cursor-pointer hover:border-primary transition-colors">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Gallery"
                                        class="w-full h-full object-cover">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Right Column: Details -->
                <div class="lg:col-span-8 space-y-8">
                    <div>
                        <div class="flex items-center gap-4 mb-4">
                            <span
                                class="px-3 py-1 bg-primary/10 text-primary text-xs font-bold uppercase tracking-wider rounded-full border border-primary/20">
                                {{ $book->category }}
                            </span>
                            @if($book->status === 'available')
                                <span
                                    class="flex items-center gap-1.5 text-green-400 text-xs font-bold uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-400"></span>
                                    Available
                                </span>
                            @else
                                <span
                                    class="flex items-center gap-1.5 text-red-400 text-xs font-bold uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                                    {{ ucfirst($book->status) }}
                                </span>
                            @endif
                        </div>

                        <h1 class="text-4xl md:text-5xl font-black mb-2">{{ $book->title }}</h1>
                        <p class="text-xl text-gray-400 font-medium">by <span
                                class="text-white">{{ $book->author }}</span></p>
                    </div>

                    <!-- Pricing Card -->
                    <div class="bg-surface-dark rounded-2xl p-6 border border-white/10">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                            <div class="space-y-4">
                                @if($book->type == 'rent' || $book->type == 'both')
                                    <div class="flex items-baseline gap-2">
                                        <span
                                            class="text-3xl font-black text-primary">₹{{ number_format($book->rental_price, 0) }}</span>
                                        <span class="text-gray-400 text-sm font-medium">/ {{ $book->rental_duration_days }}
                                            days rental</span>
                                    </div>
                                @endif

                                @if($book->type == 'sale' || $book->type == 'both')
                                    <div class="flex items-baseline gap-2">
                                        <span
                                            class="text-3xl font-black text-secondary">₹{{ number_format($book->selling_price, 0) }}</span>
                                        <span class="text-gray-400 text-sm font-medium">to buy</span>
                                    </div>
                                @endif
                            </div>

                            <div class="flex flex-col gap-3">
                                @if(Auth::check())
                                    @if($book->type == 'rent' || $book->type == 'both')
                                        @if($book->quantity > 0)
                                            <div class="grid grid-cols-2 gap-3">
                                                <form action="{{ route('library.cart.add') }}" method="POST" class="w-full">
                                                    @csrf
                                                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                                                    <input type="hidden" name="action" value="rent">
                                                    <button type="submit"
                                                        class="w-full py-3.5 bg-surface-light border border-primary/20 hover:border-primary/50 text-white font-bold rounded-xl transition-all flex items-center justify-center gap-2">
                                                        <span class="material-symbols-outlined text-lg">add_shopping_cart</span>
                                                        <span>Cart (Rent)</span>
                                                    </button>
                                                </form>
                                                <form action="{{ route('library.cart.add') }}" method="POST" class="w-full">
                                                    @csrf
                                                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                                                    <input type="hidden" name="action" value="rent">
                                                    <input type="hidden" name="checkout_now" value="1">
                                                    <button type="submit"
                                                        class="w-full py-3.5 bg-gradient-to-r from-primary to-primary-hover text-white font-bold rounded-xl hover:shadow-lg hover:shadow-primary/25 transition-all flex items-center justify-center gap-2">
                                                        <span class="material-symbols-outlined text-lg">key</span>
                                                        <span>Rent Now</span>
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <button disabled
                                                class="w-full py-3.5 bg-surface-light border border-white/10 text-gray-500 font-bold rounded-xl cursor-not-allowed flex items-center justify-center gap-2">
                                                <span class="material-symbols-outlined text-lg">key_off</span>
                                                <span>Rented Out</span>
                                            </button>
                                        @endif
                                    @endif

                                    @if($book->type == 'sale' || $book->type == 'both')
                                        @if($book->quantity > 0)
                                            <div class="grid grid-cols-2 gap-3">
                                                <form action="{{ route('library.cart.add') }}" method="POST" class="w-full">
                                                    @csrf
                                                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                                                    <input type="hidden" name="action" value="buy">
                                                    <button type="submit"
                                                        class="w-full py-3.5 bg-surface-light border border-white/10 hover:border-white/30 text-white font-bold rounded-xl transition-all flex items-center justify-center gap-2">
                                                        <span class="material-symbols-outlined text-lg">add_shopping_cart</span>
                                                        <span>Cart (Buy)</span>
                                                    </button>
                                                </form>
                                                <form action="{{ route('library.cart.add') }}" method="POST" class="w-full">
                                                    @csrf
                                                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                                                    <input type="hidden" name="action" value="buy">
                                                    <input type="hidden" name="checkout_now" value="1">
                                                    <button type="submit"
                                                        class="w-full py-3.5 bg-gradient-to-r from-secondary to-pink-600 text-white font-bold rounded-xl hover:shadow-lg hover:shadow-secondary/25 transition-all flex items-center justify-center gap-2">
                                                        <span class="material-symbols-outlined text-lg">shopping_bag</span>
                                                        <span>Buy Now</span>
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <button disabled
                                                class="w-full py-3.5 bg-surface-light border border-white/10 text-gray-500 font-bold rounded-xl cursor-not-allowed flex items-center justify-center gap-2">
                                                <span class="material-symbols-outlined text-lg">production_quantity_limits</span>
                                                <span>Sold Out</span>
                                            </button>
                                        @endif
                                    @endif
                                @else
                                    <a href="{{ route('login') }}"
                                        class="w-full py-3.5 bg-white text-black font-bold rounded-xl hover:bg-gray-100 transition-all flex items-center justify-center gap-2">
                                        <span class="material-symbols-outlined">lock</span>
                                        Login to Access
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="space-y-4">
                        <h3 class="text-xl font-bold text-white">About this Book</h3>
                        <div class="prose prose-invert prose-lg text-gray-400 leading-relaxed">
                            <p>{{ $book->description ?: 'No description available for this book.' }}</p>
                        </div>
                    </div>

                    <!-- Additional Details -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 py-6 border-y border-white/10">
                        <div>
                            <span
                                class="block text-xs text-gray-500 uppercase tracking-wider font-bold mb-1">Language</span>
                            <span class="text-white font-semibold">{{ $book->language ?? 'English' }}</span>
                        </div>
                        <div>
                            <span
                                class="block text-xs text-gray-500 uppercase tracking-wider font-bold mb-1">ISBN</span>
                            <span class="text-white font-semibold">{{ $book->isbn ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs text-gray-500 uppercase tracking-wider font-bold mb-1">Added
                                On</span>
                            <span class="text-white font-semibold">{{ $book->created_at->format('M d, Y') }}</span>
                        </div>
                        <div>
                            <span
                                class="block text-xs text-gray-500 uppercase tracking-wider font-bold mb-1">Stock</span>
                            <span class="text-white font-semibold">{{ $book->quantity }} copies</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Auth & Profile Modals -->
    <!-- Auth Modal -->
    <div id="authModal" class="fixed inset-0 z-[60] hidden">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeModal('authModal')">
        </div>
        <div
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md bg-surface-dark border border-white/10 rounded-2xl p-6 shadow-2xl transform transition-all scale-100">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-primary/10 mb-4">
                    <span class="material-symbols-outlined text-primary text-2xl">lock</span>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">Authentication Required</h3>
                <p class="text-gray-400 text-sm mb-6">Please log in or register to rent or buy books.</p>
                <div class="flex gap-3">
                    <a href="{{ route('login') }}"
                        class="flex-1 py-2.5 bg-surface-light hover:bg-white/10 text-white font-bold rounded-xl border border-white/10 transition-all text-sm">Log
                        In</a>
                    <a href="{{ route('register') }}"
                        class="flex-1 py-2.5 bg-gradient-to-r from-primary to-secondary text-white font-bold rounded-xl hover:shadow-lg hover:shadow-primary/30 transition-all text-sm">Register</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Completion Modal -->
    <div id="profileModal" class="fixed inset-0 z-[60] hidden">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity"
            onclick="closeModal('profileModal')"></div>
        <div
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md bg-white dark:bg-surface-dark border border-gray-200 dark:border-white/10 rounded-2xl p-6 shadow-2xl transform transition-all scale-100">
            <div class="text-center">
                <div
                    class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-orange-100 dark:bg-orange-500/10 mb-4">
                    <span class="material-symbols-outlined text-orange-600 dark:text-orange-500 text-2xl">warning</span>
                </div>
                <h3 class="lg:font-bold text-gray-900 dark:text-white mb-2">Incomplete Profile</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">You missed the following mandatory fields in
                    your profile page:</p>

                <ul id="missingFieldsList" class="text-left bg-gray-50 dark:bg-black/20 rounded-xl p-4 mb-6 space-y-2">
                    <!-- JS will populate this -->
                </ul>

                <p class="text-gray-600 dark:text-gray-400 text-sm mb-6">Please fill these details to continue.</p>

                <a href="{{ route('profile.edit') }}"
                    class="block w-full py-2.5 bg-primary hover:bg-primary-hover text-white font-bold rounded-xl shadow-lg hover:shadow-primary/30 transition-all text-sm">
                    Go to Profile
                </a>
            </div>
        </div>
    </div>

    <!-- Back to Top Button -->
    <button id="backToTop"
        class="fixed bottom-8 right-8 p-4 bg-gradient-to-r from-primary to-secondary text-white rounded-full shadow-2xl hover:shadow-primary/50 transition-all opacity-0 pointer-events-none z-50">
        <span class="material-symbols-outlined">arrow_upward</span>
    </button>

    <script>
        // Auth Logic
        const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
        const missingFields = @json($missingFields ?? []);
        const bookId = {{ $book->id }};

        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            if (id === 'profileModal') {
                const list = document.getElementById('missingFieldsList');
                list.innerHTML = missingFields.map(field => `
                    <li class="flex items-center gap-2 text-sm text-red-600 dark:text-red-400">
                        <span class="material-symbols-outlined text-lg">error</span>
                        ${field}
                    </li>
                `).join('');
            }
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        function checkRequirements() {
            if (!isLoggedIn) {
                openModal('authModal');
                return false;
            }
            return true;
        }

        function checkRequirements() {
            if (!isLoggedIn) {
                openModal('authModal');
                return false;
            }
            return true;
        }

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

        // Search functionality
        const topSearch = document.getElementById('topSearch');
        if (topSearch) {
            topSearch.addEventListener('keypress', function (e) {
                if (e.key === 'Enter') {
                    // Redirect to library with search param
                    // window.location.href = "{{ route('library.index') }}?q=" + encodeURIComponent(e.target.value);
                    // For now just console log as the library page handles search
                    console.log('Search:', e.target.value);
                }
            });
        }
    </script>
</body>

</html>