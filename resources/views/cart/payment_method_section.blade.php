<!-- Payment Method -->
<div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden p-6">
    <h2 class="text-lg font-medium text-gray-900 mb-4">Payment Method</h2>
    
    <div class="space-y-6">
        <div>
            <div class="space-y-4">
                <!-- Cash on Delivery Option -->
                <div class="flex items-center">
                    <input id="payment_method_type_cod" name="payment_method_type" type="radio" value="cod" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500" {{ old('payment_method_type') == 'cod' ? 'checked' : 'checked' }}>
                    <label for="payment_method_type_cod" class="ml-3 block text-sm font-medium text-gray-700">
                        Cash on Delivery
                    </label>
                </div>
                
                <!-- Saved Payment Methods -->
                @if(isset($paymentMethods) && $paymentMethods->count() > 0)
                    <div class="flex items-center">
                        <input id="payment_method_type_saved" name="payment_method_type" type="radio" value="saved" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500" {{ old('payment_method_type') == 'saved' ? 'checked' : '' }}>
                        <label for="payment_method_type_saved" class="ml-3 block text-sm font-medium text-gray-700">
                            Use Saved Payment Method
                        </label>
                    </div>
                    
                    <div id="saved_payment_methods_container" class="ml-7 mt-3 space-y-3 {{ old('payment_method_type') == 'saved' ? '' : 'hidden' }}">
                        @foreach($paymentMethods as $method)
                            <div class="flex items-center">
                                <input id="payment_method_{{ $method->id }}" name="payment_method_id" type="radio" value="{{ $method->id }}" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500" {{ old('payment_method_id') == $method->id || (!old('payment_method_id') && $method->is_default) ? 'checked' : '' }}>
                                <label for="payment_method_{{ $method->id }}" class="ml-3 flex flex-col">
                                    <span class="text-sm font-medium text-gray-700">{{ $method->name }}</span>
                                    <span class="text-sm text-gray-500">
                                        @if($method->type === 'credit_card' || $method->type === 'debit_card')
                                            {{ $method->getMaskedCardNumber() }} • Expires {{ $method->getExpiryDate() }}
                                        @else
                                            {{ $method->getFormattedType() }}
                                        @endif
                                    </span>
                                </label>
                            </div>
                        @endforeach
                        
                        <div class="mt-3">
                            <a href="{{ route('payment-methods.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900">Manage Payment Methods</a>
                        </div>
                    </div>
                @endif
                
                <!-- Credit Card Option -->
                <div class="flex items-center">
                    <input id="payment_method_type_new" name="payment_method_type" type="radio" value="new" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500" {{ old('payment_method_type') == 'new' ? 'checked' : '' }}>
                    <label for="payment_method_type_new" class="ml-3 block text-sm font-medium text-gray-700">
                        Credit or Debit Card
                    </label>
                </div>
            </div>
        </div>
    </div>
    
    <div class="bg-indigo-50 p-4 rounded-lg mt-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-indigo-700">
                    For credit/debit card payments, our staff will contact you by phone to arrange secure payment processing.
                </p>
            </div>
        </div>
    </div>
</div>
