<section>
    @if(Auth::user()->kyc_status === 'approved')
        <div
            class="p-6 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border-2 border-green-200 dark:border-green-700 rounded-2xl">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-green-500 rounded-full">
                    <span class="material-symbols-outlined text-3xl text-white">verified</span>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-green-800 dark:text-green-200">KYC Verified!</h3>
                    <p class="text-sm text-green-700 dark:text-green-300">Your identity has been successfully verified. You
                        can now rent and buy books.</p>
                </div>
            </div>
        </div>
    @elseif(Auth::user()->kyc_status === 'pending' && Auth::user()->aadhaar_path)
        <div
            class="p-6 bg-gradient-to-r from-yellow-50 to-amber-50 dark:from-yellow-900/20 dark:to-amber-900/20 border-2 border-yellow-200 dark:border-yellow-700 rounded-2xl">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-yellow-500 rounded-full animate-pulse">
                    <span class="material-symbols-outlined text-3xl text-white">pending</span>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-yellow-800 dark:text-yellow-200">Under Review</h3>
                    <p class="text-sm text-yellow-700 dark:text-yellow-300">Your documents are being reviewed by our admin
                        team. Please wait for approval.</p>
                </div>
            </div>
        </div>
    @elseif(Auth::user()->kyc_status === 'rejected')
        <div
            class="p-6 bg-gradient-to-r from-red-50 to-rose-50 dark:from-red-900/20 dark:to-rose-900/20 border-2 border-red-200 dark:border-red-700 rounded-2xl mb-6">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-red-500 rounded-full">
                    <span class="material-symbols-outlined text-3xl text-white">error</span>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-red-800 dark:text-red-200">KYC Rejected</h3>
                    <p class="text-sm text-red-700 dark:text-red-300">Your documents were rejected. Please re-upload valid
                        documents.</p>
                </div>
            </div>
        </div>
    @endif

    @if(Auth::user()->kyc_status !== 'approved' && (Auth::user()->kyc_status !== 'pending' || !Auth::user()->aadhaar_path))
        <form method="post" action="{{ route('kyc.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Aadhaar Card -->
            <div class="group">
                <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                    <span class="material-symbols-outlined text-lg text-purple-500">credit_card</span>
                    {{ __('Aadhaar Card') }}
                    <span class="text-xs text-red-500">*</span>
                </label>
                <div class="relative">
                    <input id="aadhaar" name="aadhaar" type="file" accept=".jpg,.jpeg,.png,.pdf" required
                        class="block w-full text-sm text-gray-900 dark:text-gray-100 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none focus:border-purple-500 focus:ring-4 focus:ring-purple-500/20 transition-all duration-200 file:mr-4 file:py-3 file:px-4 file:rounded-l-xl file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 dark:file:bg-purple-900/30 dark:file:text-purple-300" />
                </div>
                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">PDF, JPG, or PNG (Max 2MB)</p>
                <x-input-error class="mt-2" :messages="$errors->get('aadhaar')" />
            </div>

            <!-- PAN Card -->
            <div class="group">
                <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                    <span class="material-symbols-outlined text-lg text-purple-500">badge</span>
                    {{ __('PAN Card') }}
                    <span class="text-xs text-red-500">*</span>
                </label>
                <div class="relative">
                    <input id="pan" name="pan" type="file" accept=".jpg,.jpeg,.png,.pdf" required
                        class="block w-full text-sm text-gray-900 dark:text-gray-100 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none focus:border-purple-500 focus:ring-4 focus:ring-purple-500/20 transition-all duration-200 file:mr-4 file:py-3 file:px-4 file:rounded-l-xl file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 dark:file:bg-purple-900/30 dark:file:text-purple-300" />
                </div>
                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">PDF, JPG, or PNG (Max 2MB)</p>
                <x-input-error class="mt-2" :messages="$errors->get('pan')" />
            </div>

            <!-- Address Proof -->
            <div class="group">
                <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                    <span class="material-symbols-outlined text-lg text-purple-500">home</span>
                    {{ __('Address Proof') }}
                    <span class="text-xs text-red-500">*</span>
                </label>
                <div class="relative">
                    <input id="address_proof" name="address_proof" type="file" accept=".jpg,.jpeg,.png,.pdf" required
                        class="block w-full text-sm text-gray-900 dark:text-gray-100 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none focus:border-purple-500 focus:ring-4 focus:ring-purple-500/20 transition-all duration-200 file:mr-4 file:py-3 file:px-4 file:rounded-l-xl file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 dark:file:bg-purple-900/30 dark:file:text-purple-300" />
                </div>
                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Passport, Voter ID, or Driving License (Max 2MB)
                </p>
                <x-input-error class="mt-2" :messages="$errors->get('address_proof')" />
            </div>

            <!-- Submit Button -->
            <div class="flex items-center gap-4 pt-4">
                <button type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 flex items-center gap-2">
                    <span class="material-symbols-outlined">upload</span>
                    {{ __('Submit for Verification') }}
                </button>

                @if (session('status') === 'kyc-uploaded')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                        class="text-sm text-green-600 dark:text-green-400 font-medium flex items-center gap-2">
                        <span class="material-symbols-outlined text-lg">check_circle</span>
                        {{ __('Documents uploaded successfully!') }}
                    </p>
                @endif
            </div>
        </form>
    @endif
</section>