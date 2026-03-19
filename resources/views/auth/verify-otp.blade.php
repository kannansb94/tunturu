<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by entering the OTP we just emailed to you?') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            {{ __('A new OTP has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <form method="POST" action="{{ route('otp.verify') }}">
        @csrf

        <!-- OTP Input -->
        <div>
            <x-input-label for="otp" :value="__('Enter OTP')" />
            <x-text-input id="otp" class="block mt-1 w-full text-center tracking-[1em] font-bold text-xl" type="text"
                name="otp" required autofocus />
            <x-input-error :messages="$errors->get('otp')" class="mt-2" />
        </div>

        <div class="mt-4 flex items-center justify-end">
            <x-primary-button>
                {{ __('Verify Email') }}
            </x-primary-button>
        </div>
    </form>

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('otp.resend') }}">
            @csrf
            <button type="submit"
                class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                {{ __('Resend OTP') }}
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>