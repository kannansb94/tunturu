@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Create New Role</h1>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">Define a new role and assign its permissions.</p>
                    </div>
                    <a href="{{ route('library.admin.settings.index') }}"
                        class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <span class="material-symbols-outlined">arrow_back</span>
                        Back to Settings
                    </a>
                </div>
            </div>

            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-8">
                    <form action="{{ route('library.admin.roles.store') }}" method="POST" class="space-y-8">
                        @csrf

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Role
                                Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                                placeholder="e.g. Content Moderator">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Permissions -->
                        <div>
                            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4 block">Assign Permissions
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($availablePermissions as $key => $label)
                                    <label
                                        class="relative flex items-start p-4 rounded-xl border border-gray-200 dark:border-gray-700 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <div class="flex items-center h-5">
                                            <input type="checkbox" name="permissions[]" value="{{ $key }}"
                                                class="h-4 w-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500 bg-gray-100 dark:bg-gray-700 dark:border-gray-600">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <span class="font-medium text-gray-900 dark:text-white">{{ $label }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            <x-input-error :messages="$errors->get('permissions')" class="mt-2" />
                        </div>

                        <div class="pt-6 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                            <button type="submit"
                                class="px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-semibold rounded-xl transition-all flex items-center gap-2">
                                <span class="material-symbols-outlined">save</span>
                                Create Role
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection