<x-layouts.main>
    <x-slot name="title">Checkout</x-slot>

    <div class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Checkout</h1>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Checkout Form -->
                <div class="lg:col-span-2">
                    <form id="order-form" action="{{ route('orders.store') }}" method="POST" class="space-y-8">
                        @csrf
                        
                        <!-- Shipping Information -->
                        <div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden p-6">
                            <h2 class="text-lg font-medium text-gray-900 mb-4">Shipping Information</h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="shipping_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                    <input type="text" name="shipping_name" id="shipping_name" value="{{ old('shipping_name', $user->name) }}" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('shipping_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="shipping_phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                    <input type="tel" name="shipping_phone" id="shipping_phone" value="{{ old('shipping_phone', $user->phone) }}" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('shipping_phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-1">Street Address</label>
                                    <input type="text" name="shipping_address" id="shipping_address" value="{{ old('shipping_address', $user->address) }}" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('shipping_address')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="shipping_city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                    <input type="text" name="shipping_city" id="shipping_city" value="{{ old('shipping_city', $user->city) }}" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('shipping_city')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="shipping_state" class="block text-sm font-medium text-gray-700 mb-1">State/Province</label>
                                    <input type="text" name="shipping_state" id="shipping_state" value="{{ old('shipping_state', $user->state) }}" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('shipping_state')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="shipping_zip" class="block text-sm font-medium text-gray-700 mb-1">Postal/ZIP Code</label>
                                    <input type="text" name="shipping_zip" id="shipping_zip" value="{{ old('shipping_zip', $user->postal_code) }}" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('shipping_zip')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="shipping_country" class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                                    <input type="text" name="shipping_country" id="shipping_country" value="{{ old('shipping_country', $user->country ?? 'Indonesia') }}" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('shipping_country')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Billing Information -->
                        <div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-lg font-medium text-gray-900">Billing Information</h2>
                                <div class="flex items-center">
                                    <input id="same-as-shipping" name="same_as_shipping" type="checkbox" checked class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="same-as-shipping" class="ml-2 text-sm text-gray-600">Same as shipping</label>
                                </div>
                            </div>
                            
                            <div id="billing-fields" class="grid grid-cols-1 md:grid-cols-2 gap-6 hidden">
                                <div>
                                    <label for="billing_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                    <input type="text" name="billing_name" id="billing_name" value="{{ old('billing_name', $user->name) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('billing_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="billing_phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                    <input type="tel" name="billing_phone" id="billing_phone" value="{{ old('billing_phone', $user->phone) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('billing_phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label for="billing_address" class="block text-sm font-medium text-gray-700 mb-1">Street Address</label>
                                    <input type="text" name="billing_address" id="billing_address" value="{{ old('billing_address', $user->address) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('billing_address')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="billing_city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                    <input type="text" name="billing_city" id="billing_city" value="{{ old('billing_city', $user->city) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('billing_city')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="billing_state" class="block text-sm font-medium text-gray-700 mb-1">State/Province</label>
                                    <input type="text" name="billing_state" id="billing_state" value="{{ old('billing_state', $user->state) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('billing_state')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="billing_zip" class="block text-sm font-medium text-gray-700 mb-1">Postal/ZIP Code</label>
                                    <input type="text" name="billing_zip" id="billing_zip" value="{{ old('billing_zip', $user->postal_code) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('billing_zip')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="billing_country" class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                                    <input type="text" name="billing_country" id="billing_country" value="{{ old('billing_country', $user->country ?? 'Indonesia') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('billing_country')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Order Notes -->
                        <div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden p-6">
                            <h2 class="text-lg font-medium text-gray-900 mb-4">Additional Information</h2>
                            
                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Order Notes (optional)</label>
                                <textarea name="notes" id="notes" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Special instructions for delivery or any other notes">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                        
                        <!-- Payment Method -->
                        @include('cart.payment_method_section')
                        
                        <!-- Submit Button (Mobile Only) -->
                        <div class="lg:hidden">
                            <button type="submit" form="order-form" class="w-full bg-indigo-600 border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                                Place Order
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-gray-50 rounded-lg p-6 border border-gray-200 shadow-sm sticky top-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h2>
                        
                        <!-- Cart Items -->
                        <div class="flow-root mb-6">
                            <ul class="-my-4 divide-y divide-gray-200">
                                @foreach ($cartItems as $item)
                                    <li class="flex py-4">
                                        <div class="flex-shrink-0 w-16 h-16 bg-gray-200 rounded-md overflow-hidden">
                                            @if($item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4 flex-1 flex flex-col">
                                            <div>
                                                <div class="flex justify-between">
                                                    <h3 class="text-sm font-medium text-gray-900">
                                                        {{ $item->product->name }}
                                                    </h3>
                                                    <p class="ml-4 text-sm font-medium text-gray-900">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</p>
                                                </div>
                                                <p class="mt-1 text-sm text-gray-500">{{ $item->product->brand }}</p>
                                            </div>
                                            <div class="mt-1 flex justify-between text-sm">
                                                <p class="text-gray-500">Qty {{ $item->quantity }}</p>
                                                <p class="text-gray-500">@ Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        
                        <!-- Totals -->
                        <dl class="border-t border-gray-200 py-4 space-y-4">
                            <div class="flex items-center justify-between">
                                <dt class="text-sm text-gray-600">Subtotal</dt>
                                <dd class="text-sm font-medium text-gray-900">Rp {{ number_format($total, 0, ',', '.') }}</dd>
                            </div>
                            <div class="flex items-center justify-between">
                                <dt class="text-sm text-gray-600">Shipping</dt>
                                <dd class="text-sm font-medium text-gray-900">Free</dd>
                            </div>
                            <div class="flex items-center justify-between">
                                <dt class="text-sm text-gray-600">Tax</dt>
                                <dd class="text-sm font-medium text-gray-900">Included</dd>
                            </div>
                            <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                                <dt class="text-base font-medium text-gray-900">Order total</dt>
                                <dd class="text-base font-bold text-indigo-600">Rp {{ number_format($total, 0, ',', '.') }}</dd>
                            </div>
                        </dl>
                        
                        <!-- Place Order Button -->
                        <div class="mt-6 hidden lg:block">
                            <button type="submit" form="order-form" class="w-full bg-indigo-600 border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                                Place Order
                            </button>
                        </div>
                        
                        <!-- Secure Checkout Information -->
                        <div class="mt-6 text-sm text-gray-500">
                            <p class="flex items-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                Your personal data is securely encrypted
                            </p>
                            <p class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Payments are processed securely
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle billing fields visibility based on checkbox
            const sameAsShippingCheckbox = document.getElementById('same-as-shipping');
            const billingFieldsDiv = document.getElementById('billing-fields');
            
            // Only execute if these elements exist
            if (sameAsShippingCheckbox && billingFieldsDiv) {
                function toggleBillingFields() {
                    if (sameAsShippingCheckbox.checked) {
                        billingFieldsDiv.classList.add('hidden');
                        // Copy shipping values to billing fields (for form submission)
                        document.getElementById('billing_name').value = document.getElementById('shipping_name').value;
                        document.getElementById('billing_phone').value = document.getElementById('shipping_phone').value;
                        document.getElementById('billing_address').value = document.getElementById('shipping_address').value;
                        document.getElementById('billing_city').value = document.getElementById('shipping_city').value;
                        document.getElementById('billing_state').value = document.getElementById('shipping_state').value;
                        document.getElementById('billing_zip').value = document.getElementById('shipping_zip').value;
                        document.getElementById('billing_country').value = document.getElementById('shipping_country').value;
                    } else {
                        billingFieldsDiv.classList.remove('hidden');
                    }
                }
                
                // Initial setup
                toggleBillingFields();
                
                // Handle checkbox changes
                sameAsShippingCheckbox.addEventListener('change', toggleBillingFields);
                
                // Copy shipping to billing when shipping fields change (if same-as-shipping is checked)
                const shippingFields = [
                    'shipping_name', 'shipping_phone', 'shipping_address', 
                    'shipping_city', 'shipping_state', 'shipping_zip', 'shipping_country'
                ];
                
                shippingFields.forEach(field => {
                    const element = document.getElementById(field);
                    if (element) {
                        element.addEventListener('input', function() {
                            if (sameAsShippingCheckbox.checked) {
                                const billingField = field.replace('shipping_', 'billing_');
                                const billingElement = document.getElementById(billingField);
                                if (billingElement) {
                                    billingElement.value = this.value;
                                }
                            }
                        });
                    }
                });
            }
            
            // Payment method handling
            const paymentTypeRadios = document.querySelectorAll('input[name="payment_method_type"]');
            const savedPaymentMethodsContainer = document.getElementById('saved_payment_methods_container');
            
            function togglePaymentMethod() {
                const selectedValue = document.querySelector('input[name="payment_method_type"]:checked')?.value;
                
                if (savedPaymentMethodsContainer) {
                    if (selectedValue === 'saved') {
                        savedPaymentMethodsContainer.classList.remove('hidden');
                    } else {
                        savedPaymentMethodsContainer.classList.add('hidden');
                    }
                }
            }
            
            // Initial setup for payment method
            togglePaymentMethod();
            
            // Handle payment method type changes
            paymentTypeRadios.forEach(radio => {
                radio.addEventListener('change', togglePaymentMethod);
            });
        });
    </script>
    @endpush
</x-layouts.main>
