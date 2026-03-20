<nav x-data="{ open: false }"
    class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 fixed top-0 w-full z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[20px]">dashboard</span>
                            {{ __('Dashboard') }}
                        </div>
                    </x-nav-link>
                </div>

                <!-- Admin Links -->
                @if(Auth::user()->isAdmin())
                    <div class="hidden space-x-6 sm:-my-px sm:ms-10 sm:flex">
                        @if(Auth::user()->hasPermission('manage_books'))
                            <x-nav-link :href="route('library.admin.books.index')"
                                :active="request()->routeIs('library.admin.books.*')">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[20px]">inventory_2</span>
                                    {{ __('Books') }}
                                </div>
                            </x-nav-link>
                        @endif

                        @if(Auth::user()->hasPermission('manage_users'))
                            <x-nav-link :href="route('library.admin.users.index')"
                                :active="request()->routeIs('library.admin.users.*')">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[20px]">group</span>
                                    {{ __('Users') }}
                                </div>
                            </x-nav-link>
                        @endif

                        @if(Auth::user()->hasPermission('view_reports'))
                            <!-- Assuming Donations falls under reports or general admin, checking specifically for donations permission if exists, otherwise fallback to SuperAdmin for now or view_reports -->
                            <!-- Checking Seeder: Donations not listed explicitly. Assuming 'manage_settings' or implicit Admin. Let's use isSuperAdmin for Users/Donations if permission missing -->
                        @endif

                        <!-- Donations -->
                        @if(Auth::user()->hasPermission('manage_donations'))
                            <x-nav-link :href="route('library.admin.donations.index')"
                                :active="request()->routeIs('library.admin.donations.*')">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[20px]">volunteer_activism</span>
                                    {{ __('Donations') }}
                                </div>
                            </x-nav-link>
                        @endif

                        @if(Auth::user()->hasPermission('manage_categories'))
                            <x-nav-link :href="route('library.admin.categories.index')"
                                :active="request()->routeIs('library.admin.categories.*')">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[20px]">category</span>
                                    {{ __('Categories') }}
                                </div>
                            </x-nav-link>
                        @endif

                        @if(Auth::user()->hasPermission('manage_rentals'))
                            <x-nav-link :href="route('library.admin.rentals.index')"
                                :active="request()->routeIs('library.admin.rentals.*')">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[20px]">key</span>
                                    {{ __('Rentals') }}
                                </div>
                            </x-nav-link>
                        @endif

                        @if(Auth::user()->hasPermission('manage_sales'))
                            <x-nav-link :href="route('library.admin.sales.index')"
                                :active="request()->routeIs('library.admin.sales.*')">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[20px]">point_of_sale</span>
                                    {{ __('Sales') }}
                                </div>
                            </x-nav-link>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-3">
                <!-- Notification Bell (Admin Only) -->
                @if(Auth::user()->role === 'admin')
                    <x-dropdown align="right" width="w-80 sm:w-96">
                        <x-slot name="trigger">
                            <button
                                class="relative p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <span class="material-symbols-outlined">notifications</span>
                                @if(Auth::user()->unreadNotifications->count() > 0)
                                    <span
                                        class="absolute top-1 right-1 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-red-100 transform translate-x-1/4 -translate-y-1/4 bg-red-600 rounded-full">
                                        {{ Auth::user()->unreadNotifications->count() }}
                                    </span>
                                @endif
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div
                                class="px-4 py-2 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Notifications</span>
                                @if(Auth::user()->unreadNotifications->count() > 0)
                                    <a href="{{ route('library.admin.notifications.markAllRead') }}"
                                        class="text-xs text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">Mark
                                        all read</a>
                                @endif
                            </div>

                            <div class="max-h-64 overflow-y-auto">
                                @php
                                    $notifications = Auth::user()->notifications;
                                @endphp
                                @forelse($notifications as $notification)
                                    <a href="{{ route('library.admin.notifications.markRead', $notification->id) }}"
                                        class="block px-4 py-3 border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150 ease-in-out {{ $notification->read_at ? 'opacity-75' : 'bg-blue-50/50 dark:bg-blue-900/10' }}">
                                        <div class="flex items-start">
                                            <div class="shrink-0 pt-0.5">
                                                @if($notification->data['type'] === 'order')
                                                    <span
                                                        class="material-symbols-outlined text-green-500 text-lg">shopping_cart</span>
                                                @else
                                                    <span class="material-symbols-outlined text-blue-500 text-lg">book_online</span>
                                                @endif
                                            </div>
                                            <div class="ml-3 w-0 flex-1">
                                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $notification->data['message'] }}
                                                </p>
                                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $notification->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400">
                                        No notifications
                                    </div>
                                @endforelse
                            </div>
                        </x-slot>
                    </x-dropdown>
                @endif
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">person</span>
                                {{ __('Profile') }}
                            </div>
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                <div class="flex items-center gap-2 text-red-600 dark:text-red-400">
                                    <span class="material-symbols-outlined text-sm">logout</span>
                                    {{ __('Log Out') }}
                                </div>
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">dashboard</span>
                    {{ __('Dashboard') }}
                </div>
            </x-responsive-nav-link>

            <!-- Admin Mobile Links -->
            @if(Auth::user()->isAdmin())
                @if(Auth::user()->hasPermission('manage_books'))
                    <x-responsive-nav-link :href="route('library.admin.books.index')"
                        :active="request()->routeIs('library.admin.books.*')">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-lg">inventory_2</span>
                            {{ __('Books') }}
                        </div>
                    </x-responsive-nav-link>
                @endif

                @if(Auth::user()->hasPermission('manage_users'))
                    <x-responsive-nav-link :href="route('library.admin.users.index')"
                        :active="request()->routeIs('library.admin.users.*')">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-lg">group</span>
                            {{ __('Users') }}
                        </div>
                    </x-responsive-nav-link>
                @endif

                @if(Auth::user()->hasPermission('manage_donations'))
                    <x-responsive-nav-link :href="route('library.admin.donations.index')"
                        :active="request()->routeIs('library.admin.donations.*')">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-lg">volunteer_activism</span>
                            {{ __('Donations') }}
                        </div>
                    </x-responsive-nav-link>
                @endif

                @if(Auth::user()->hasPermission('manage_categories'))
                    <x-responsive-nav-link :href="route('library.admin.categories.index')"
                        :active="request()->routeIs('library.admin.categories.*')">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-lg">category</span>
                            {{ __('Categories') }}
                        </div>
                    </x-responsive-nav-link>
                @endif

                @if(Auth::user()->hasPermission('manage_rentals'))
                    <x-responsive-nav-link :href="route('library.admin.rentals.index')"
                        :active="request()->routeIs('library.admin.rentals.*')">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-lg">key</span>
                            {{ __('Rentals') }}
                        </div>
                    </x-responsive-nav-link>
                @endif

                @if(Auth::user()->hasPermission('manage_sales'))
                    <x-responsive-nav-link :href="route('library.admin.sales.index')"
                        :active="request()->routeIs('library.admin.sales.*')">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-lg">point_of_sale</span>
                            {{ __('Sales') }}
                        </div>
                    </x-responsive-nav-link>
                @endif
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">person</span>
                        {{ __('Profile') }}
                    </div>
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        <div class="flex items-center gap-2 text-red-600 dark:text-red-400">
                            <span class="material-symbols-outlined text-sm">logout</span>
                            {{ __('Log Out') }}
                        </div>
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>