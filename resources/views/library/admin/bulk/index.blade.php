@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <a href="{{ route('library.admin.index') }}"
                    class="inline-flex items-center gap-2 text-orange-600 dark:text-orange-400 hover:text-orange-700 dark:hover:text-orange-300 mb-4">
                    <span class="material-symbols-outlined">arrow_back</span>
                    Back to Dashboard
                </a>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Bulk Upload Books</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Import multiple books at once using a CSV file.</p>
            </div>

            <!-- Upload Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-8">





                <!-- Validation Errors List -->
                @if(session('errors_list'))
                    <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-xl">
                        <h3 class="font-semibold text-red-800 dark:text-red-300 mb-2 flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">warning</span>
                            Errors in CSV
                        </h3>
                        <ul class="list-disc list-inside text-sm text-red-700 dark:text-red-400 space-y-1">
                            @foreach(session('errors_list') as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Instructions -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Instructions</h2>
                        <ul class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                            <li class="flex items-start gap-2">
                                <span class="material-symbols-outlined text-blue-500 text-lg">download</span>
                                <div>
                                    <p class="font-medium text-gray-800 dark:text-gray-200">1. Download Template</p>
                                    <p>Get the CSV template with the correct column headers.</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="material-symbols-outlined text-blue-500 text-lg">edit_note</span>
                                <div>
                                    <p class="font-medium text-gray-800 dark:text-gray-200">2. Fill Data</p>
                                    <p>Add your book details. Required columns: Title, Author, Selling Price, Quantity.</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="material-symbols-outlined text-blue-500 text-lg">upload_file</span>
                                <div>
                                    <p class="font-medium text-gray-800 dark:text-gray-200">3. Upload</p>
                                    <p>Select your CSV file and click "Import Books".</p>
                                </div>
                            </li>
                        </ul>

                        <div class="mt-6">
                            <a href="{{ route('library.admin.bulk.template') }}"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/40 transition-colors font-semibold">
                                <span class="material-symbols-outlined">download</span>
                                Download CSV Template
                            </a>
                        </div>
                    </div>

                    <!-- Upload Form -->
                    <div
                        class="bg-gray-50 dark:bg-gray-700/30 rounded-xl p-6 border border-dashed border-gray-300 dark:border-gray-600">
                        <form method="POST" action="{{ route('library.admin.bulk.store') }}" enctype="multipart/form-data"
                            class="text-center">
                            @csrf

                            <div class="mb-6">
                                <span class="material-symbols-outlined text-6xl text-gray-400 mb-2">cloud_upload</span>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Upload CSV File</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Only .csv files are allowed</p>
                            </div>

                            <input type="file" name="file" accept=".csv" required class="block w-full text-sm text-gray-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-orange-50 file:text-orange-700
                                        hover:file:bg-orange-100
                                        mb-6
                                    " />

                            <button type="submit"
                                class="w-full px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-xl shadow-lg transition-all flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined">publish</span>
                                Import Books
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection