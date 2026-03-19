<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    @if($user->rentals()->whereIn('status', ['active', 'overdue'])->exists())
        <div class="rounded-md bg-red-50 p-4 border border-red-200">
            <div class="flex">
                <div class="flex-shrink-0">
                    <span class="material-symbols-outlined text-red-500">error</span>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Account Deletion Unavailable</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <p>You cannot delete your account while you have active or overdue rentals. Please return all books
                            first.</p>
                    </div>
                </div>
            </div>
        </div>
    @else
        <x-danger-button x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">{{ __('Delete Account') }}</x-danger-button>

        <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
            <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                @csrf
                @method('delete')

                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Are you sure you want to delete your account?') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </p>

                <div class="mt-6">
                    <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-3/4"
                        placeholder="{{ __('Password') }}" />

                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                    <x-input-error :messages="$errors->userDeletion->get('rentals')" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-danger-button class="ms-3">
                        {{ __('Delete Account') }}
                    </x-danger-button>
                </div>
            </form>
        </x-modal>
    @endif
</section>