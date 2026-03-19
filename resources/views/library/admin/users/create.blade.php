@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Create New User</h1>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">Add a new user to the system with specific roles.
                        </p>
                    </div>
                    <a href="{{ route('library.admin.users.index') }}"
                        class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <span class="material-symbols-outlined">arrow_back</span>
                        Back to Users
                    </a>
                </div>
            </div>

            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-8">
                    <form action="{{ route('library.admin.users.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Full
                                Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                placeholder="John Doe">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Email
                                Address</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                placeholder="john@example.com">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Role Selection -->
                        <div>
                            <label for="role" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Role
                                & Permissions</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @php
                                    $roles = \App\Models\Role::all();
                                @endphp
                                @foreach($roles as $role)
                                    <label
                                        class="relative flex items-start p-4 rounded-xl border border-gray-200 dark:border-gray-700 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <div class="flex items-center h-5">
                                            <input type="radio" name="role" value="{{ $role->slug }}" required
                                                class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600"
                                                {{ old('role') == $role->slug ? 'checked' : '' }}>
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <span class="font-medium text-gray-900 dark:text-white">{{ $role->name }}</span>
                                            <p class="text-gray-500 dark:text-gray-400 text-xs mt-1">
                                                {{ implode(', ', array_slice($role->permissions ?? [], 0, 3)) }}
                                                @if(count($role->permissions ?? []) > 3)...@endif
                                            </p>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="password"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Password</label>
                                <input type="password" name="password" id="password" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                    placeholder="••••••••">
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div>
                                <label for="password_confirmation"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Confirm
                                    Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                    placeholder="••••••••">
                            </div>
                        </div>

                        <div class="pt-6 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                            <button type="submit"
                                class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all flex items-center gap-2">
                                <span class="material-symbols-outlined">person_add</span>
                                Create User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection