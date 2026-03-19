@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex items-center justify-between">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Edit Category: {{ $category->name }}</h2>
                <a href="{{ route('library.admin.categories.index') }}"
                    class="text-gray-600 dark:text-gray-400 hover:text-white transition-colors">
                    &larr; Back to Categories
                </a>
            </div>

            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-8 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('library.admin.categories.update', $category) }}" method="POST"
                        class="space-y-6">
                        @csrf
                        @method('PUT')

                        @if ($errors->any())
                            <div
                                class="bg-red-50 dark:bg-red-900/50 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 p-4 rounded-md">
                                <ul class="list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="name">
                                Category Name <span class="text-red-500">*</span>
                            </label>
                            <input
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                id="name" name="name" required type="text" value="{{ old('name', $category->name) }}" />
                        </div>

                        <!-- Slug -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="slug">
                                Slug (URL)
                                <span class="text-xs text-gray-500 font-normal ml-2">Leave blank to auto-generate</span>
                            </label>
                            <input
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                id="slug" name="slug" type="text" value="{{ old('slug', $category->slug) }}"
                                placeholder="e.g. non-fiction" />
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                                for="description">
                                Description (Optional)
                            </label>
                            <textarea
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                id="description" name="description"
                                rows="4">{{ old('description', $category->description) }}</textarea>
                        </div>

                        <div class="flex justify-end pt-4">
                            <button
                                class="px-6 py-2 bg-primary hover:bg-primary-hover text-white rounded-md font-bold transition-colors shadow-lg"
                                type="submit">
                                Update Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection