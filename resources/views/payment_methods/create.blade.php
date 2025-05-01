<x-layouts.main>
    <x-slot name="title">Add Payment Method</x-slot>

    <div class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="max-w-3xl mx-auto">
                <h1 class="text-3xl font-bold text-gray-900 mb-6">Add Payment Method</h1>
                
                <form action="{{ route('payment-methods.store') }}" method="POST" class="space-y-8">
                    @csrf
                    
                    <!-- Basic Information -->
                    <div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h2>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Name this payment method</label>
                                <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="e.g., My Primary Card" value="{{ old('name') }}" required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700">Payment Type</label>
                                <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">Select a payment type</option>
                                    <option value="credit_card" {{ old('type') == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                                    <option value="debit_card" {{ old('type') == 'debit_card' ? 'selected' : '' }}>Debit Card</option>
                                    <option value="bank_transfer" {{ old('type') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                </select>
                                @error('type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Credit/Debit Card Details (conditional) -->
                    <div id="card-details" class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden p-6 hidden">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Card Details</h2>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="card_holder" class="block text-sm font-medium text-gray-700">Cardholder Name</label>
                                <input type="text" name="card_holder" id="card_holder" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Name on card" value="{{ old('card_holder') }}">
                                @error('card_holder')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="card_number" class="block text-sm font-medium text-gray-700">Card Number</label>
                                <input type="text" name="card_number" id="card_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="1234 5678 9012 3456" value="{{ old('card_number') }}" maxlength="19">
                                @error('card_number')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="grid grid-cols-3 gap-4">
                                <div class="col-span-1">
                                    <label for="expiry_month" class="block text-sm font-medium text-gray-700">Expiry Month</label>
                                    <input type="text" name="expiry_month" id="expiry_month" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="MM" value="{{ old('expiry_month') }}" maxlength="2">
                                    @error('expiry_month')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="col-span-1">
                                    <label for="expiry_year" class="block text-sm font-medium text-gray-700">Expiry Year</label>
                                    <input type="text" name="expiry_year" id="expiry_year" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="YY" value="{{ old('expiry_year') }}" maxlength="2">
                                    @error('expiry_year')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="col-span-1">
                                    <label for="cvv" class="block text-sm font-medium text-gray-700">CVV</label>
                                    <input type="text" name="cvv" id="cvv" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="123" value="{{ old('cvv') }}" maxlength="4">
                                    @error('cvv')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Bank Transfer Details (conditional) -->
                    <div id="bank-details" class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden p-6 hidden">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Bank Account Details</h2>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="bank_name" class="block text-sm font-medium text-gray-700">Bank Name</label>
                                <input type="text" name="bank_name" id="bank_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="e.g., BCA, Mandiri, BNI" value="{{ old('bank_name') }}">
                                @error('bank_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="account_number" class="block text-sm font-medium text-gray-700">Account Number</label>
                                <input type="text" name="account_number" id="account_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Your account number" value="{{ old('account_number') }}">
                                @error('account_number')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="account_holder" class="block text-sm font-medium text-gray-700">Account Holder Name</label>
                                <input type="text" name="account_holder" id="account_holder" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Name on account" value="{{ old('account_holder') }}">
                                @error('account_holder')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Security Notice -->
                    <div class="bg-indigo-50 p-4 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-indigo-700">
                                    Your payment information is securely encrypted using AES-256 encryption. We never store your complete card details in plaintext.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <a href="{{ route('payment-methods.index') }}" class="mr-4 bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Save Payment Method
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('type');
            const cardDetailsDiv = document.getElementById('card-details');
            const bankDetailsDiv = document.getElementById('bank-details');
            
            function updateFormFields() {
                const selectedType = typeSelect.value;
                
                if (selectedType === 'credit_card' || selectedType === 'debit_card') {
                    cardDetailsDiv.classList.remove('hidden');
                    bankDetailsDiv.classList.add('hidden');
                } else if (selectedType === 'bank_transfer') {
                    cardDetailsDiv.classList.add('hidden');
                    bankDetailsDiv.classList.remove('hidden');
                } else {
                    cardDetailsDiv.classList.add('hidden');
                    bankDetailsDiv.classList.add('hidden');
                }
            }
            
            // Initial setup
            updateFormFields();
            
            // Handle type changes
            typeSelect.addEventListener('change', updateFormFields);
            
            // Format card number with spaces
            const cardNumberInput = document.getElementById('card_number');
            if (cardNumberInput) {
                cardNumberInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
                    
                    if (value.length > 0) {
                        value = value.match(new RegExp('.{1,4}', 'g')).join(' ');
                    }
                    
                    e.target.value = value;
                });
            }
        });
    </script>
    @endpush
</x-layouts.main>
