<x-layouts.main>
    <x-slot name="title">Process Payment</x-slot>
    
    <div class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Complete Your Payment</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Payment Gateway -->
                <div class="md:col-span-2">
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg border border-gray-200">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900">Payment Method</h2>
                            <p class="mt-1 text-sm text-gray-500">Select your preferred payment method below.</p>
                        </div>
                        
                        <div class="px-4 py-5 sm:p-6">
                            <!-- Midtrans Payment UI Container -->
                            <div id="snap-container" class="min-h-[500px] flex items-center justify-center">
                                <div class="text-center">
                                    <svg class="animate-spin h-10 w-10 text-indigo-600 mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <p class="text-gray-500">Loading payment options...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment Instructions -->
                    <div class="mt-8 bg-white shadow overflow-hidden sm:rounded-lg border border-gray-200">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900">Payment Instructions</h2>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-gray-900">Secure Payment</h3>
                                        <p class="text-sm text-gray-500">Your payment information is securely processed.</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-gray-900">Multiple Payment Options</h3>
                                        <p class="text-sm text-gray-500">Choose from credit/debit cards, bank transfers, e-wallets, and more.</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-gray-900">Instant Confirmation</h3>
                                        <p class="text-sm text-gray-500">Receive order confirmation immediately after successful payment.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Order Summary -->
                <div class="md:col-span-1">
                    <div class="bg-gray-50 rounded-lg p-6 border border-gray-200 shadow-sm sticky top-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h2>
                        
                        <dl class="space-y-4">
                            <div class="flex justify-between items-center">
                                <dt class="text-sm text-gray-600">Order Number</dt>
                                <dd class="text-sm font-medium text-gray-900">#{{ $order->order_number }}</dd>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <dt class="text-sm text-gray-600">Date</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $order->created_at->format('M d, Y') }}</dd>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <dt class="text-sm text-gray-600">Items</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $order->orderItems->sum('quantity') }}</dd>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <dt class="text-sm text-gray-600">Subtotal</dt>
                                <dd class="text-sm font-medium text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</dd>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <dt class="text-sm text-gray-600">Shipping</dt>
                                <dd class="text-sm font-medium text-gray-900">Free</dd>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <dt class="text-sm text-gray-600">Tax</dt>
                                <dd class="text-sm font-medium text-gray-900">Included</dd>
                            </div>
                            
                            <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                                <dt class="text-base font-medium text-gray-900">Total</dt>
                                <dd class="text-base font-bold text-indigo-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</dd>
                            </div>
                        </dl>
                        
                        <div class="mt-6 text-sm text-gray-500">
                            <p class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                100% Secure Transaction
                            </p>
                            <p class="flex items-center mt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                Data Encryption
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Back to Order Button -->
            <div class="mt-8">
                <a href="{{ route('orders.show', $order) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                    <span aria-hidden="true">&larr;</span> Back to Order
                </a>
            </div>
        </div>
    </div>
    
    <!-- Midtrans Scripts -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the payment token from the Midtrans response
            const snapToken = "{{ $paymentDetails['snap_token'] }}";
            
            // Initialize Snap
            snap.pay(snapToken, {
                // Optional callbacks
                onSuccess: function(result) {
                    // Payment success
                    window.location.href = "{{ route('payment.success', $order) }}?transaction_id=" + result.transaction_id + "&payment_type=" + result.payment_type;
                },
                onPending: function(result) {
                    // Payment pending
                    window.location.href = "{{ route('orders.show', $order) }}";
                },
                onError: function(result) {
                    // Payment error
                    window.location.href = "{{ route('payment.failed', $order) }}";
                },
                onClose: function() {
                    // Customer closed the popup without finishing the payment
                    // Redirect back to order page
                    window.location.href = "{{ route('orders.show', $order) }}";
                }
            });
        });
    </script>
</x-layouts.main>
