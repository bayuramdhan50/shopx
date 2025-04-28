<x-layouts.main>
    <x-slot name="title">Shopping Cart</x-slot>

    <div class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Shopping Cart</h1>
            
            @if ($cartItems->isEmpty())
                <div class="bg-gray-50 rounded-lg p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <h2 class="text-xl font-medium text-gray-900 mb-2">Your cart is empty</h2>
                    <p class="text-gray-500 mb-6">Looks like you haven't added any products to your cart yet.</p>
                    <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Browse Products
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Cart Items -->
                    <div class="lg:col-span-2">
                        <div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden">
                            <ul class="divide-y divide-gray-200">
                                @foreach ($cartItems as $item)
                                    <li class="p-4 sm:p-6">
                                        <div class="flex flex-col sm:flex-row">
                                            <!-- Product Image -->
                                            <div class="flex-shrink-0 w-full sm:w-32 h-32 bg-gray-200 rounded-md overflow-hidden mb-4 sm:mb-0">
                                                @if($item->product->image)
                                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center">
                                                        <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            <!-- Product Details -->
                                            <div class="sm:ml-6 flex-1">
                                                <div class="flex justify-between mb-4">
                                                    <div>
                                                        <h3 class="text-lg font-medium text-gray-900">
                                                            <a href="{{ route('products.show', $item->product) }}" class="hover:text-indigo-600">
                                                                {{ $item->product->name }}
                                                            </a>
                                                        </h3>
                                                        <p class="mt-1 text-sm text-gray-500">{{ $item->product->brand }}</p>
                                                        <p class="mt-1 text-sm text-gray-500">Category: {{ $item->product->category }}</p>
                                                    </div>
                                                    <p class="text-lg font-medium text-indigo-600">
                                                        Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                                    </p>
                                                </div>
                                                
                                                <div class="flex justify-between items-end">
                                                    <!-- Quantity Form -->
                                                    <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center">
                                                        @csrf
                                                        @method('PATCH')
                                                        <label for="quantity-{{ $item->id }}" class="sr-only">Quantity</label>
                                                        <div class="flex items-center border border-gray-300 rounded-md">
                                                            <button type="button" class="decrement-quantity px-3 py-1 text-gray-600 hover:bg-gray-100">-</button>
                                                            <input type="number" id="quantity-{{ $item->id }}" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ min(10, $item->product->stock) }}" class="w-12 text-center border-0 focus:ring-0">
                                                            <button type="button" class="increment-quantity px-3 py-1 text-gray-600 hover:bg-gray-100">+</button>
                                                        </div>
                                                        <button type="submit" class="ml-2 text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                                            Update
                                                        </button>
                                                    </form>
                                                    
                                                    <!-- Subtotal and Remove Button -->
                                                    <div class="flex items-center">
                                                        <p class="text-sm font-medium text-gray-900 mr-4">
                                                            Subtotal: Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                                        </p>
                                                        <form action="{{ route('cart.remove', $item) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-500">
                                                                Remove
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        
                        <!-- Cart Actions -->
                        <div class="mt-4 flex justify-between items-center">
                            <a href="{{ route('products.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                <span aria-hidden="true">&larr;</span> Continue Shopping
                            </a>
                            <form action="{{ route('cart.clear') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-500" onclick="return confirm('Are you sure you want to clear your cart?')">
                                    Clear Cart
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-gray-50 rounded-lg p-6 border border-gray-200 shadow-sm sticky top-6">
                            <h2 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h2>
                            
                            <div class="flow-root">
                                <dl class="-my-4 text-sm divide-y divide-gray-200">
                                    <div class="py-4 flex items-center justify-between">
                                        <dt class="text-gray-600">Subtotal</dt>
                                        <dd class="font-medium text-gray-900">Rp {{ number_format($total, 0, ',', '.') }}</dd>
                                    </div>
                                    <div class="py-4 flex items-center justify-between">
                                        <dt class="text-gray-600">Shipping</dt>
                                        <dd class="font-medium text-gray-900">Free</dd>
                                    </div>
                                    <div class="py-4 flex items-center justify-between">
                                        <dt class="text-gray-600">Tax</dt>
                                        <dd class="font-medium text-gray-900">Included</dd>
                                    </div>
                                    <div class="py-4 flex items-center justify-between">
                                        <dt class="text-base font-medium text-gray-900">Order total</dt>
                                        <dd class="text-base font-bold text-indigo-600">Rp {{ number_format($total, 0, ',', '.') }}</dd>
                                    </div>
                                </dl>
                            </div>
                            
                            <div class="mt-6">
                                <a href="{{ route('cart.checkout') }}" class="w-full bg-indigo-600 border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                    </svg>
                                    Proceed to Checkout
                                </a>
                            </div>
                            
                            <div class="mt-6 text-sm text-gray-500">
                                <p class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    Your personal data is securely encrypted
                                </p>
                                <p class="flex items-center mt-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Secure payment processing
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle quantity buttons
            const decrementButtons = document.querySelectorAll('.decrement-quantity');
            const incrementButtons = document.querySelectorAll('.increment-quantity');
            
            decrementButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.parentNode.querySelector('input[type="number"]');
                    const currentValue = parseInt(input.value);
                    if (currentValue > 1) {
                        input.value = currentValue - 1;
                    }
                });
            });
            
            incrementButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.parentNode.querySelector('input[type="number"]');
                    const currentValue = parseInt(input.value);
                    const maxValue = parseInt(input.getAttribute('max'));
                    if (currentValue < maxValue) {
                        input.value = currentValue + 1;
                    }
                });
            });
        });
    </script>
    @endpush
</x-layouts.main>
