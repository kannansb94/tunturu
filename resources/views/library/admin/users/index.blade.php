@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div
                class="mb-8 relative overflow-hidden rounded-2xl bg-gradient-to-r from-purple-600 via-pink-600 to-red-600 p-8 shadow-2xl">
                <div class="absolute inset-0 bg-black/10"></div>
                <div class="relative z-10 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="p-4 bg-white/20 backdrop-blur-sm rounded-full">
                            <span class="material-symbols-outlined text-5xl text-white">group</span>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-white mb-1">User Management</h1>
                            <p class="text-white/90">Manage users and KYC verification</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search -->
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 mb-6">
                <form action="{{ route('library.admin.users.index') }}" method="GET" class="flex gap-4">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Search by name, email, or phone..."
                        class="flex-1 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-500 focus:ring-purple-500">
                    <button type="submit"
                        class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-xl transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined">search</span>
                        Search
                    </button>
                    @if($search)
                        <a href="{{ route('library.admin.users.index') }}"
                            class="px-6 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-xl transition-all">
                            Clear
                        </a>
                    @endif
                </form>
            </div>

            <!-- Tab Buttons -->
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
                <!-- Waiting for Approval Button -->
                <button onclick="showTab('pending')" id="pending-btn"
                    class="tab-btn active-tab px-4 py-3 rounded-2xl shadow-lg border-2 transition-all duration-200 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-xl">pending</span>
                        <div class="text-left hidden lg:block">
                            <h3 class="font-bold text-sm">Waiting</h3>
                            <p class="text-xs opacity-80 truncate" style="max-width: 100px;">Pending KYC</p>
                        </div>
                    </div>
                    <span class="px-2 py-1 rounded-full text-xs font-bold bg-white/50">{{ $pendingUsers->count() }}</span>
                </button>

                <!-- Approved Button -->
                <button onclick="showTab('approved')" id="approved-btn"
                    class="tab-btn px-4 py-3 rounded-2xl shadow-lg border-2 transition-all duration-200 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-xl">check_circle</span>
                        <div class="text-left hidden lg:block">
                            <h3 class="font-bold text-sm">Approved</h3>
                            <p class="text-xs opacity-80 truncate" style="max-width: 100px;">Verified</p>
                        </div>
                    </div>
                    <span class="px-2 py-1 rounded-full text-xs font-bold bg-white/50">{{ $approvedUsers->count() }}</span>
                </button>

                <!-- Rejected Button -->
                <button onclick="showTab('rejected')" id="rejected-btn"
                    class="tab-btn px-4 py-3 rounded-2xl shadow-lg border-2 transition-all duration-200 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-xl">cancel</span>
                        <div class="text-left hidden lg:block">
                            <h3 class="font-bold text-sm">Rejected</h3>
                            <p class="text-xs opacity-80 truncate" style="max-width: 100px;">Declined</p>
                        </div>
                    </div>
                    <span class="px-2 py-1 rounded-full text-xs font-bold bg-white/50">{{ $rejectedUsers->count() }}</span>
                </button>

                <!-- Banned Button -->
                <button onclick="showTab('banned')" id="banned-btn"
                    class="tab-btn px-4 py-3 rounded-2xl shadow-lg border-2 transition-all duration-200 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-xl">gavel</span>
                        <div class="text-left hidden lg:block">
                            <h3 class="font-bold text-sm">Banned</h3>
                            <p class="text-xs opacity-80 truncate" style="max-width: 100px;">Revoked Access</p>
                        </div>
                    </div>
                    <span class="px-2 py-1 rounded-full text-xs font-bold bg-white/50">{{ $bannedUsers->count() }}</span>
                </button>

                <!-- Deleted Button -->
                <button onclick="showTab('deleted')" id="deleted-btn"
                    class="tab-btn px-4 py-3 rounded-2xl shadow-lg border-2 transition-all duration-200 flex items-center justify-between flex-col md:flex-row col-span-2 md:col-span-1">
                    <div class="flex items-center gap-2 w-full md:w-auto justify-center md:justify-start">
                        <span class="material-symbols-outlined text-xl">delete</span>
                        <div class="text-left hidden lg:block">
                            <h3 class="font-bold text-sm">Deleted</h3>
                            <p class="text-xs opacity-80 truncate" style="max-width: 100px;">Soft Deleted</p>
                        </div>
                    </div>
                    <span
                        class="px-2 py-1 rounded-full text-xs font-bold bg-white/50 mt-2 md:mt-0">{{ $deletedUsers->count() }}</span>
                </button>
            </div>

            <!-- Tab Content -->
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <!-- Pending Users -->
                <div id="pending-content" class="tab-content">
                    @if($pendingUsers->isEmpty())
                        <div class="p-12 text-center">
                            <span class="material-symbols-outlined text-6xl text-gray-400 mb-4">pending</span>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No Pending Users</h3>
                            <p class="text-gray-600 dark:text-gray-400">All KYC verifications are up to date.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                            User</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                            Contact</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                            Joined</th>
                                        <th
                                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($pendingUsers as $user)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    <div
                                                        class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-full flex items-center justify-center">
                                                        <span
                                                            class="text-sm font-bold text-white">{{ substr($user->name, 0, 1) }}</span>
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                            {{ $user->name }}</div>
                                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                                            {{ ucfirst($user->role) }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900 dark:text-gray-100">{{ $user->email }}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $user->phone ?? 'N/A' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                                {{ $user->created_at->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 text-right text-sm font-medium">
                                                <div class="flex items-center justify-end gap-3">
                                                    <a href="{{ route('library.admin.users.show', $user) }}"
                                                        class="text-purple-600 hover:text-purple-900 dark:text-purple-400 dark:hover:text-purple-300 font-semibold"
                                                        title="View Details">
                                                        <span class="material-symbols-outlined text-xl">visibility</span>
                                                    </a>
                                                    <form action="{{ route('library.admin.users.ban', $user) }}" method="POST"
                                                        onsubmit="return confirm('Are you sure you want to ban this user?');"
                                                        class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                            class="text-orange-600 hover:text-orange-900 dark:text-orange-400 dark:hover:text-orange-300 font-semibold"
                                                            title="Ban User">
                                                            <span class="material-symbols-outlined text-xl">gavel</span>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('library.admin.users.destroy', $user) }}" method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this user?');"
                                                        class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 font-semibold"
                                                            title="Delete User">
                                                            <span class="material-symbols-outlined text-xl">delete</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                <!-- Approved Users -->
                <div id="approved-content" class="tab-content hidden">
                    @if($approvedUsers->isEmpty())
                        <div class="p-12 text-center">
                            <span class="material-symbols-outlined text-6xl text-gray-400 mb-4">check_circle</span>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No Approved Users</h3>
                            <p class="text-gray-600 dark:text-gray-400">No users have been approved yet.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                            User</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                            Contact</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                            Joined</th>
                                        <th
                                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($approvedUsers as $user)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    <div
                                                        class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-green-500 to-emerald-500 rounded-full flex items-center justify-center">
                                                        <span
                                                            class="text-sm font-bold text-white">{{ substr($user->name, 0, 1) }}</span>
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                            {{ $user->name }}</div>
                                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                                            {{ ucfirst($user->role) }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900 dark:text-gray-100">{{ $user->email }}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $user->phone ?? 'N/A' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                                {{ $user->created_at->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 text-right text-sm font-medium">
                                                <div class="flex items-center justify-end gap-3">
                                                    <a href="{{ route('library.admin.users.show', $user) }}"
                                                        class="text-purple-600 hover:text-purple-900 dark:text-purple-400 dark:hover:text-purple-300 font-semibold"
                                                        title="View Details">
                                                        <span class="material-symbols-outlined text-xl">visibility</span>
                                                    </a>
                                                    <form action="{{ route('library.admin.users.ban', $user) }}" method="POST"
                                                        onsubmit="return confirm('Are you sure you want to ban this user?');"
                                                        class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                            class="text-orange-600 hover:text-orange-900 dark:text-orange-400 dark:hover:text-orange-300 font-semibold"
                                                            title="Ban User">
                                                            <span class="material-symbols-outlined text-xl">gavel</span>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('library.admin.users.destroy', $user) }}" method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this user?');"
                                                        class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 font-semibold"
                                                            title="Delete User">
                                                            <span class="material-symbols-outlined text-xl">delete</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                <!-- Rejected Users -->
                <div id="rejected-content" class="tab-content hidden">
                    @if($rejectedUsers->isEmpty())
                        <div class="p-12 text-center">
                            <span class="material-symbols-outlined text-6xl text-gray-400 mb-4">cancel</span>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No Rejected Users</h3>
                            <p class="text-gray-600 dark:text-gray-400">No users have been rejected.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                            User</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                            Contact</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                            Joined</th>
                                        <th
                                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($rejectedUsers as $user)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    <div
                                                        class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-red-500 to-pink-500 rounded-full flex items-center justify-center">
                                                        <span
                                                            class="text-sm font-bold text-white">{{ substr($user->name, 0, 1) }}</span>
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                            {{ $user->name }}</div>
                                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                                            {{ ucfirst($user->role) }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900 dark:text-gray-100">{{ $user->email }}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $user->phone ?? 'N/A' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                                {{ $user->created_at->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 text-right text-sm font-medium">
                                                <div class="flex items-center justify-end gap-3">
                                                    <a href="{{ route('library.admin.users.show', $user) }}"
                                                        class="text-purple-600 hover:text-purple-900 dark:text-purple-400 dark:hover:text-purple-300 font-semibold"
                                                        title="View Details">
                                                        <span class="material-symbols-outlined text-xl">visibility</span>
                                                    </a>
                                                    <form action="{{ route('library.admin.users.kyc.undo_reject', $user) }}" method="POST"
                                                        onsubmit="return confirm('Are you sure you want to undo this rejection?');"
                                                        class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                            class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 font-semibold"
                                                            title="Undo Rejection">
                                                            <span class="material-symbols-outlined text-xl">undo</span>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('library.admin.users.ban', $user) }}" method="POST"
                                                        onsubmit="return confirm('Are you sure you want to ban this user?');"
                                                        class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                            class="text-orange-600 hover:text-orange-900 dark:text-orange-400 dark:hover:text-orange-300 font-semibold"
                                                            title="Ban User">
                                                            <span class="material-symbols-outlined text-xl">gavel</span>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('library.admin.users.destroy', $user) }}" method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this user?');"
                                                        class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 font-semibold"
                                                            title="Delete User">
                                                            <span class="material-symbols-outlined text-xl">delete</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                <!-- Banned Users -->
                <div id="banned-content" class="tab-content hidden">
                    @if($bannedUsers->isEmpty())
                        <div class="p-12 text-center">
                            <span class="material-symbols-outlined text-6xl text-gray-400 mb-4">gavel</span>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No Banned Users</h3>
                            <p class="text-gray-600 dark:text-gray-400">No users have been banned.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                            User</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                            Contact</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                            Joined</th>
                                        <th
                                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($bannedUsers as $user)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    <div
                                                        class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-orange-500 to-red-500 rounded-full flex items-center justify-center">
                                                        <span
                                                            class="text-sm font-bold text-white">{{ substr($user->name, 0, 1) }}</span>
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                            {{ $user->name }}</div>
                                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                                            {{ ucfirst($user->role) }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900 dark:text-gray-100">{{ $user->email }}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $user->phone ?? 'N/A' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                                {{ $user->created_at->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 text-right text-sm font-medium">
                                                <div class="flex items-center justify-end gap-3">
                                                    <a href="{{ route('library.admin.users.show', $user) }}"
                                                        class="text-purple-600 hover:text-purple-900 dark:text-purple-400 dark:hover:text-purple-300 font-semibold"
                                                        title="View Details">
                                                        <span class="material-symbols-outlined text-xl">visibility</span>
                                                    </a>
                                                    <form action="{{ route('library.admin.users.unban', $user->id) }}" method="POST"
                                                        onsubmit="return confirm('Are you sure you want to unban this user?');"
                                                        class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                            class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 font-semibold"
                                                            title="Unban User">
                                                            <span class="material-symbols-outlined text-xl">gavel</span>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('library.admin.users.destroy', $user) }}" method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this user?');"
                                                        class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 font-semibold"
                                                            title="Delete User">
                                                            <span class="material-symbols-outlined text-xl">delete</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                <!-- Deleted Users -->
                <div id="deleted-content" class="tab-content hidden">
                    @if($deletedUsers->isEmpty())
                        <div class="p-12 text-center">
                            <span class="material-symbols-outlined text-6xl text-gray-400 mb-4">delete</span>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No Deleted Users</h3>
                            <p class="text-gray-600 dark:text-gray-400">No users have been deleted.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                            User</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                            Contact</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                            Deleted at</th>
                                        <th
                                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($deletedUsers as $user)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors opacity-75">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    <div
                                                        class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-gray-500 to-gray-700 rounded-full flex items-center justify-center">
                                                        <span
                                                            class="text-sm font-bold text-white">{{ substr($user->name, 0, 1) }}</span>
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                            {{ $user->name }}</div>
                                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                                            {{ ucfirst($user->role) }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900 dark:text-gray-100">{{ $user->email }}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $user->phone ?? 'N/A' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                                {{ $user->deleted_at->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 text-right text-sm font-medium">
                                                <div class="flex items-center justify-end gap-3">
                                                    <a href="{{ route('library.admin.users.show', $user->id) }}"
                                                        class="text-purple-600 hover:text-purple-900 dark:text-purple-400 dark:hover:text-purple-300 font-semibold"
                                                        title="View Details">
                                                        <span class="material-symbols-outlined text-xl">visibility</span>
                                                    </a>
                                                    <form action="{{ route('library.admin.users.restore', $user->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure you want to restore this user?');"
                                                        class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                            class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 font-semibold"
                                                            title="Restore User">
                                                            <span
                                                                class="material-symbols-outlined text-xl">restore_from_trash</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .tab-btn {
            background: white;
            border-color: #e5e7eb;
            color: #6b7280;
        }

        .dark .tab-btn {
            background: #1f2937;
            border-color: #374151;
            color: #9ca3af;
        }

        /* Active states for pending, approved, rejected... */
        #pending-btn.active-tab {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-color: #f59e0b;
            color: #92400e;
            transform: scale(1.02);
        }

        .dark #pending-btn.active-tab {
            background: linear-gradient(135deg, #78350f 0%, #92400e 100%);
            border-color: #f59e0b;
            color: #fef3c7;
        }

        #approved-btn.active-tab {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            border-color: #10b981;
            color: #065f46;
            transform: scale(1.02);
        }

        .dark #approved-btn.active-tab {
            background: linear-gradient(135deg, #064e3b 0%, #065f46 100%);
            border-color: #10b981;
            color: #d1fae5;
        }

        #rejected-btn.active-tab {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            border-color: #ef4444;
            color: #991b1b;
            transform: scale(1.02);
        }

        .dark #rejected-btn.active-tab {
            background: linear-gradient(135deg, #7f1d1d 0%, #991b1b 100%);
            border-color: #ef4444;
            color: #fee2e2;
        }

        #banned-btn.active-tab {
            background: linear-gradient(135deg, #ffedd5 0%, #ffbd3a 100%);
            border-color: #f97316;
            color: #9a3412;
            transform: scale(1.02);
        }

        .dark #banned-btn.active-tab {
            background: linear-gradient(135deg, #7c2d12 0%, #9a3412 100%);
            border-color: #ea580c;
            color: #ffedd5;
        }

        #deleted-btn.active-tab {
            background: linear-gradient(135deg, #e5e7eb 0%, #d1d5db 100%);
            border-color: #9ca3af;
            color: #374151;
            transform: scale(1.02);
        }

        .dark #deleted-btn.active-tab {
            background: linear-gradient(135deg, #374151 0%, #4b5563 100%);
            border-color: #6b7280;
            color: #f3f4f6;
        }

        .tab-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .tab-btn.active-tab:hover {
            transform: scale(1.02) translateY(-2px);
        }
    </style>

    <script>
        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });

            // Remove active class from all buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active-tab');
            });

            // Show selected tab content
            document.getElementById(tabName + '-content').classList.remove('hidden');

            // Add active class to selected button
            document.getElementById(tabName + '-btn').classList.add('active-tab');
        }

        // Show pending tab by default
        document.addEventListener('DOMContentLoaded', function () {
            showTab('pending');
        });
    </script>
@endsection