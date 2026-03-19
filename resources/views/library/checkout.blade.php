<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-100 text-red-700 border border-red-300 rounded-xl">
                    <strong>Error:</strong> {{ session('error') }}
                </div>
            @endif
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-100 text-red-700 border border-red-300 rounded-xl">
                    <ul class="list-disc list-inside space-y-1 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Left: Order Summary --}}
                <div class="lg:col-span-1 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 h-fit">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Order Summary</h3>

                    <div class="space-y-4 mb-6 max-h-60 overflow-y-auto pr-2">
                        @foreach($cartItems as $item)
                            @if($item->book)
                                <div class="flex items-start gap-4">
                                    @if($item->book->cover_image)
                                        <img src="{{ asset('storage/' . $item->book->cover_image) }}" alt="{{ $item->book->title }}"
                                            class="w-16 h-20 object-cover rounded-lg shadow-sm">
                                    @else
                                        <div
                                            class="w-16 h-20 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                            <span class="material-symbols-outlined text-2xl text-gray-400">book</span>
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <h4 class="text-sm font-bold text-gray-900 dark:text-white line-clamp-1"
                                            title="{{ $item->book->title }}">{{ $item->book->title }}</h4>
                                        <span
                                            class="inline-block mt-1 px-2 py-0.5 {{ $item->type === 'rent' ? 'bg-primary/10 text-primary' : 'bg-secondary/10 text-secondary' }} text-[10px] font-bold rounded-full uppercase">
                                            {{ $item->type === 'rent' ? 'Renting' : 'Buying' }} (x{{ $item->quantity }})
                                        </span>
                                        <div class="mt-1 text-sm font-medium text-gray-900 dark:text-white">
                                            ₹{{ number_format($item->type === 'buy' ? ($item->book->selling_price * $item->quantity) : ($item->book->rental_price * $item->quantity), 2) }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600 dark:text-gray-400">Items Total</span>
                            <span
                                class="text-gray-900 dark:text-white font-medium">₹{{ number_format($totalPrice, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600 dark:text-gray-400">Processing Fee</span>
                            <span class="text-gray-900 dark:text-white font-medium">₹0.00</span>
                        </div>
                        <div
                            class="flex justify-between items-center pt-2 border-t border-gray-200 dark:border-gray-700 mt-2">
                            <span class="text-lg font-bold text-gray-900 dark:text-white">Total</span>
                            <span class="text-lg font-bold text-primary">₹{{ number_format($totalPrice, 2) }}</span>
                        </div>
                    </div>
                </div>

                {{-- Right: Delivery + Payment --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Delivery Details --}}
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Delivery Details</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-5">Pre-filled from your profile. You can
                            change these for this order.</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Full Name
                                    <span class="text-red-500">*</span></label>
                                <input type="text" id="delivery_name"
                                    value="{{ old('delivery_name', $user->name ?? '') }}"
                                    class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primary focus:ring-primary"
                                    placeholder="Recipient name">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone
                                    Number <span class="text-red-500">*</span></label>
                                <input type="text" id="delivery_phone"
                                    value="{{ old('delivery_phone', $user->phone ?? '') }}"
                                    class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primary focus:ring-primary"
                                    placeholder="Contact number">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Delivery
                                    Address <span class="text-red-500">*</span></label>
                                <textarea id="delivery_address" rows="3"
                                    class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primary focus:ring-primary"
                                    placeholder="Full street address, city, state, PIN">{{ old('delivery_address', $user->address ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Payment Method --}}
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Select Payment Method</h3>

                        {{-- COD & Wallet form --}}
                        <form id="standard-checkout-form" action="{{ route('library.checkout.process') }}"
                            method="POST">
                            @csrf
                            {{-- These hidden fields get filled from the delivery inputs above --}}
                            <input type="hidden" name="delivery_name" id="form_delivery_name">
                            <input type="hidden" name="delivery_phone" id="form_delivery_phone">
                            <input type="hidden" name="delivery_address" id="form_delivery_address">

                            <div class="space-y-3 mb-6">
                                <label
                                    class="relative flex items-center p-4 rounded-xl border-2 border-primary cursor-pointer payment-option"
                                    data-method="online">
                                    <input type="radio" name="payment_method" value="online" checked
                                        class="payment-radio h-4 w-4 text-primary border-gray-300">
                                    <div class="ml-4 flex-1">
                                        <span class="block text-sm font-medium text-gray-900 dark:text-white">Online
                                            Payment</span>
                                        <p class="text-xs text-gray-500">Credit Card, UPI, NetBanking via Razorpay</p>
                                    </div>
                                    <span class="material-symbols-outlined text-blue-500 ml-4">credit_card</span>
                                </label>

                                <label
                                    class="relative flex items-center p-4 rounded-xl border border-gray-200 dark:border-gray-700 cursor-pointer hover:border-primary/50 payment-option"
                                    data-method="cod">
                                    <input type="radio" name="payment_method" value="cod"
                                        class="payment-radio h-4 w-4 text-primary border-gray-300">
                                    <div class="ml-4 flex-1">
                                        <span class="block text-sm font-medium text-gray-900 dark:text-white">Cash on
                                            Delivery</span>
                                        <p class="text-xs text-gray-500">Pay when you receive the book</p>
                                    </div>
                                    <span class="material-symbols-outlined text-green-600 ml-4">payments</span>
                                </label>

                                <!-- Wallet option removed -->
                            </div>

                            <button type="button" id="place-order-btn"
                                class="w-full py-3 px-4 bg-gradient-to-r from-pink-500 via-purple-500 to-indigo-500 bg-[length:200%_auto] hover:bg-[position:right_center] text-white font-bold rounded-xl shadow-[0_4px_20px_rgba(168,85,247,0.4)] hover:shadow-[0_8px_30px_rgba(168,85,247,0.6)] hover:-translate-y-1 transition-all duration-500 flex items-center justify-center gap-2 group">
                                <span id="btn-label">Pay with Razorpay</span>
                                <span class="material-symbols-outlined">arrow_forward</span>
                            </button>
                        </form>

                        {{-- Hidden Razorpay callback form --}}
                        <form id="razorpay-callback-form" action="{{ route('library.checkout.verify-payment') }}"
                            method="POST" class="hidden">
                            @csrf
                            <input type="hidden" name="delivery_name" id="rp_delivery_name">
                            <input type="hidden" name="delivery_phone" id="rp_delivery_phone">
                            <input type="hidden" name="delivery_address" id="rp_delivery_address">
                            <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
                            <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                            <input type="hidden" name="razorpay_signature" id="razorpay_signature">
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        const razorpayKeyId = "{{ $razorpayKeyId }}";
        const totalPrice = {{ (int) round($totalPrice * 100) }};
        const userName = "{{ addslashes(Auth::user()->name ?? '') }}";
        const userEmail = "{{ Auth::user()->email ?? '' }}";
        const createOrderUrl = "{{ route('library.checkout.create-razorpay-order') }}";
        const csrfToken = "{{ csrf_token() }}";

        const radios = document.querySelectorAll('.payment-radio');
        const labels = document.querySelectorAll('.payment-option');
        const btnLabel = document.getElementById('btn-label');
        const placeBtn = document.getElementById('place-order-btn');

        radios.forEach(radio => {
            radio.addEventListener('change', function () {
                labels.forEach(l => {
                    l.classList.remove('border-2', 'border-primary');
                    l.classList.add('border', 'border-gray-200');
                });
                this.closest('.payment-option').classList.add('border-2', 'border-primary');
                this.closest('.payment-option').classList.remove('border', 'border-gray-200');

                btnLabel.textContent = this.value === 'online'
                    ? 'Pay with Razorpay'
                    : 'Place Order (Cash on Delivery)';
            });
        });

        function getDeliveryDetails() {
            return {
                name: document.getElementById('delivery_name').value.trim(),
                phone: document.getElementById('delivery_phone').value.trim(),
                address: document.getElementById('delivery_address').value.trim(),
            };
        }

        function validateDelivery() {
            const d = getDeliveryDetails();
            if (!d.name || !d.phone || !d.address) {
                alert('Please fill in all delivery details (Name, Phone, Address) before proceeding.');
                document.getElementById('delivery_name').focus();
                return false;
            }
            return true;
        }

        placeBtn.addEventListener('click', function () {
            if (!validateDelivery()) return;

            const d = getDeliveryDetails();
            const selectedMethod = document.querySelector('.payment-radio:checked').value;

            if (selectedMethod === 'online') {
                placeBtn.disabled = true;
                btnLabel.textContent = 'Initiating Payment...';

                fetch(createOrderUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ cart_checkout: true }),
                })
                    .then(res => res.json())
                    .then(data => {
                        if (!data.success) {
                            alert(data.message || 'Could not initiate payment. Please try again.');
                            placeBtn.disabled = false;
                            btnLabel.textContent = 'Pay with Razorpay';
                            return;
                        }

                        const options = {
                            key: razorpayKeyId,
                            amount: data.amount,
                            currency: data.currency,
                            name: 'Tunturu Library',
                            description: 'Library Cart Checkout',
                            order_id: data.razorpay_order_id,
                            prefill: { name: userName, email: userEmail },
                            theme: { color: '#7c3aed' },
                            handler: function (response) {
                                // Fill Razorpay callback form with both payment IDs and delivery details
                                document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
                                document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                                document.getElementById('razorpay_signature').value = response.razorpay_signature;
                                document.getElementById('rp_delivery_name').value = d.name;
                                document.getElementById('rp_delivery_phone').value = d.phone;
                                document.getElementById('rp_delivery_address').value = d.address;
                                document.getElementById('razorpay-callback-form').submit();
                            },
                            modal: {
                                ondismiss: function () {
                                    placeBtn.disabled = false;
                                    btnLabel.textContent = 'Pay with Razorpay';
                                }
                            }
                        };
                        new Razorpay(options).open();
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Network error. Please try again.');
                        placeBtn.disabled = false;
                        btnLabel.textContent = 'Pay with Razorpay';
                    });

            } else {
                // COD / Wallet — fill hidden delivery fields, then standard submit
                document.getElementById('form_delivery_name').value = d.name;
                document.getElementById('form_delivery_phone').value = d.phone;
                document.getElementById('form_delivery_address').value = d.address;
                document.getElementById('standard-checkout-form').submit();
            }
        });
    </script>
</x-app-layout>