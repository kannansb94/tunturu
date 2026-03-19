<section>
    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div class="group">
            <label for="update_password_current_password"
                class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                <span class="material-symbols-outlined text-lg text-green-500">lock_open</span>
                {{ __('Current Password') }}
            </label>
            <input id="update_password_current_password" name="current_password" type="password"
                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-green-500 focus:ring-4 focus:ring-green-500/20 transition-all duration-200"
                placeholder="Enter current password" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <!-- New Password -->
        <div class="group">
            <label for="update_password_password"
                class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                <span class="material-symbols-outlined text-lg text-green-500">lock</span>
                {{ __('New Password') }}
            </label>
            <input id="update_password_password" name="password" type="password"
                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-green-500 focus:ring-4 focus:ring-green-500/20 transition-all duration-200"
                placeholder="Enter new password" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="group">
            <label for="update_password_password_confirmation"
                class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                <span class="material-symbols-outlined text-lg text-green-500">lock_reset</span>
                {{ __('Confirm Password') }}
            </label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-green-500 focus:ring-4 focus:ring-green-500/20 transition-all duration-200"
                placeholder="Confirm new password" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Save Button -->
        <div class="flex items-center gap-4 pt-4">
            <button type="submit"
                class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 flex items-center gap-2">
                <span class="material-symbols-outlined">shield</span>
                {{ __('Update Password') }}
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm text-green-600 dark:text-green-400 font-medium flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">check_circle</span>
                    {{ __('Password updated!') }}
                </p>
            @endif
        </div>
    </form>
</section>