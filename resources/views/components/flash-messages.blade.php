@if (session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
        class="fixed bottom-6 right-6 z-50 w-full max-w-sm bg-green-100 border border-green-400 text-green-700 rounded-lg shadow-lg overflow-hidden"
        role="alert">
        <div class="flex items-start p-4">
            <div class="flex-shrink-0">
                <span class="material-symbols-outlined text-green-600 text-xl">check_circle</span>
            </div>
            <div class="ml-3 w-0 flex-1 pt-0.5">
                <p class="text-sm font-medium">Success!</p>
                <p class="text-sm mt-1">{{ session('success') }}</p>
            </div>
            <div class="ml-4 flex-shrink-0 flex">
                <button @click="show = false"
                    class="inline-flex text-green-500 focus:outline-none focus:text-green-700 transition ease-in-out duration-150">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
@endif

@if (session('error'))
    <div x-data="{ show: true }" x-show="show"
        class="fixed bottom-6 right-6 z-50 w-full max-w-sm bg-red-100 border border-red-400 text-red-700 rounded-lg shadow-lg overflow-hidden"
        role="alert">
        <div class="flex items-start p-4">
            <div class="flex-shrink-0">
                <span class="material-symbols-outlined text-red-600 text-xl">error</span>
            </div>
            <div class="ml-3 w-0 flex-1 pt-0.5">
                <p class="text-sm font-medium">Error!</p>
                <p class="text-sm mt-1">{{ session('error') }}</p>
            </div>
            <div class="ml-4 flex-shrink-0 flex">
                <button @click="show = false"
                    class="inline-flex text-red-500 focus:outline-none focus:text-red-700 transition ease-in-out duration-150">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
@endif

@if ($errors->any())
    <div x-data="{ show: true }" x-show="show"
        class="fixed bottom-6 right-6 z-50 w-full max-w-sm bg-red-100 border border-red-400 text-red-700 rounded-lg shadow-lg overflow-hidden"
        role="alert">
        <div class="flex items-start p-4">
            <div class="flex-shrink-0">
                <span class="material-symbols-outlined text-red-600 text-xl">warning</span>
            </div>
            <div class="ml-3 w-0 flex-1 pt-0.5">
                <p class="text-sm font-medium">Whoops!</p>
                <p class="text-sm mt-1">Something went wrong.</p>
                <ul class="mt-1 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="ml-4 flex-shrink-0 flex">
                <button @click="show = false"
                    class="inline-flex text-red-500 focus:outline-none focus:text-red-700 transition ease-in-out duration-150">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
@endif