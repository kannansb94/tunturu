<section>
    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <!-- Name Field -->
        <div class="group">
            <label for="name"
                class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                <span class="material-symbols-outlined text-lg text-blue-500">badge</span>
                {{ __('Full Name') }}
            </label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus
                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all duration-200"
                placeholder="Enter your full name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Email Field -->
        <div class="group">
            <label for="email"
                class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                <span class="material-symbols-outlined text-lg text-blue-500">mail</span>
                {{ __('Email Address') }}
            </label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all duration-200"
                placeholder="your.email@example.com" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div class="mt-3 p-4 bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-500 rounded-r-lg">
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-yellow-600 dark:text-yellow-400">warning</span>
                        <div>
                            <p class="text-sm text-yellow-800 dark:text-yellow-200 font-medium">
                                {{ __('Your email address is unverified.') }}
                            </p>
                            <button form="send-verification"
                                class="mt-2 text-sm text-yellow-700 dark:text-yellow-300 underline hover:text-yellow-900 dark:hover:text-yellow-100 font-medium">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </div>
                    </div>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm text-green-600 dark:text-green-400 font-medium flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">check_circle</span>
                            {{ __('A new verification link has been sent!') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Phone Field -->
        <div class="group">
            <label for="phone"
                class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                <span class="material-symbols-outlined text-lg text-blue-500">phone</span>
                {{ __('Phone Number') }}
            </label>
            <input id="phone" name="phone" type="tel" value="{{ old('phone', $user->phone) }}"
                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all duration-200"
                placeholder="+91 98765 43210" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <!-- Address Field -->
        <div class="group">
            <label for="address"
                class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                <span class="material-symbols-outlined text-lg text-blue-500">home</span>
                {{ __('Address') }}
            </label>
            <textarea id="address" name="address" rows="3"
                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all duration-200 resize-none"
                placeholder="Enter your full address">{{ old('address', $user->address) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        <!-- Save Button -->
        <div class="flex items-center gap-4 pt-4">
            <button type="submit"
                class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 flex items-center gap-2">
                <span class="material-symbols-outlined">save</span>
                {{ __('Save Changes') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm text-green-600 dark:text-green-400 font-medium flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">check_circle</span>
                    {{ __('Saved successfully!') }}
                </p>
            @endif
        </div>
    </form>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="hidden">
        @csrf
    </form>
</section>