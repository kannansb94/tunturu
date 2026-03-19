<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header with Gradient -->
            <div
                class="mb-8 relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 p-8 shadow-2xl">
                <div class="absolute inset-0 bg-black/10"></div>
                <div class="relative z-10 flex items-center gap-4">
                    <div class="p-4 bg-white/20 backdrop-blur-sm rounded-full">
                        <span class="material-symbols-outlined text-5xl text-white">account_circle</span>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-white mb-1">My Profile</h1>
                        <p class="text-white/90">Manage your account settings and preferences</p>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column - Profile Info & KYC -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Profile Information Card -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6">
                            <div class="flex items-center gap-3 text-white">
                                <span class="material-symbols-outlined text-3xl">person</span>
                                <h2 class="text-2xl font-bold">Profile Information</h2>
                            </div>
                        </div>
                        <div class="p-8">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    <!-- KYC Verification Card -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-6">
                            <div class="flex items-center gap-3 text-white">
                                <span class="material-symbols-outlined text-3xl">verified_user</span>
                                <h2 class="text-2xl font-bold">KYC Verification</h2>
                            </div>
                        </div>
                        <div class="p-8">
                            @include('profile.partials.kyc-form')
                        </div>
                    </div>
                </div>

                <!-- Right Column - Security & Danger Zone -->
                <div class="space-y-6">
                    <!-- Update Password Card -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <div class="bg-gradient-to-r from-green-500 to-green-600 p-6">
                            <div class="flex items-center gap-3 text-white">
                                <span class="material-symbols-outlined text-3xl">lock</span>
                                <h2 class="text-xl font-bold">Security</h2>
                            </div>
                        </div>
                        <div class="p-6">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                    <!-- Delete Account Card -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border-2 border-red-200 dark:border-red-900 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <div class="bg-gradient-to-r from-red-500 to-red-600 p-6">
                            <div class="flex items-center gap-3 text-white">
                                <span class="material-symbols-outlined text-3xl">warning</span>
                                <h2 class="text-xl font-bold">Danger Zone</h2>
                            </div>
                        </div>
                        <div class="p-6">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>