<x-layouts.main>
    <x-slot name="title">{{ $product->name }}</x-slot>

    <div class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Breadcrumbs -->
            <nav class="flex mb-8" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="text-gray-700 hover:text-indigo-600">
                            <svg class="mr-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('products.index') }}" class="ml-1 text-gray-700 hover:text-indigo-600 md:ml-2">Products</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('products.index', ['category' => $product->category_id]) }}" class="ml-1 text-gray-700 hover:text-indigo-600 md:ml-2">{{ $product->category->name ?? 'Uncategorized' }}</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-gray-500 md:ml-2">{{ $product->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Product Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <!-- Product Image -->
                <div class="bg-gray-100 rounded-lg overflow-hidden shadow-md">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-auto object-cover">
                    @else
                        <div class="w-full h-full aspect-w-1 aspect-h-1 bg-gray-200 flex items-center justify-center">
                            <svg class="w-24 h-24 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div>
                    <div class="flex items-center mb-4">
                        <span class="px-2.5 py-0.5 bg-indigo-100 text-indigo-800 rounded-full text-xs font-medium">
                            {{ $product->category->name ?? 'Uncategorized' }}
                        </span>
                        <span class="ml-3 px-2.5 py-0.5 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">
                            {{ $product->brand }}
                        </span>
                        @if($product->stock > 0)
                            <span class="ml-3 px-2.5 py-0.5 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                                In Stock ({{ $product->stock }} available)
                            </span>
                        @else
                            <span class="ml-3 px-2.5 py-0.5 bg-red-100 text-red-800 rounded-full text-xs font-medium">
                                Out of Stock
                            </span>
                        @endif
                    </div>

                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>
                    <p class="text-2xl text-indigo-600 font-bold mb-6">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold text-gray-900 mb-2">Description</h2>
                        <p class="text-gray-700">{{ $product->description }}</p>
                    </div>

                    @if($specs)
                        <div class="mb-8">
                            <h2 class="text-lg font-semibold text-gray-900 mb-2">Specifications</h2>
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                                    @foreach($specs as $key => $value)
                                        <div class="sm:col-span-1">
                                            <dt class="text-sm font-medium text-gray-500">{{ ucwords(str_replace('_', ' ', $key)) }}</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $value }}</dd>
                                        </div>
                                    @endforeach
                                </dl>
                            </div>
                        </div>
                    @endif

                    <!-- Add to Cart Form -->
                    @if($product->stock > 0)
                        <form action="{{ route('cart.add', $product) }}" method="POST" class="mb-6">
                            @csrf
                            <div class="flex items-center mb-4">
                                <label for="quantity" class="mr-4 text-gray-700 font-medium">Quantity:</label>
                                <div class="flex items-center border border-gray-300 rounded-md">
                                    <button type="button" id="decrementQuantity" class="px-3 py-2 text-gray-600 hover:bg-gray-100">-</button>
                                    <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ min(10, $product->stock) }}" class="w-16 text-center border-0 focus:ring-0">
                                    <button type="button" id="incrementQuantity" class="px-3 py-2 text-gray-600 hover:bg-gray-100">+</button>
                                </div>
                            </div>
                            
                            <div class="flex flex-col sm:flex-row gap-4">
                                <button type="submit" class="w-full sm:w-auto bg-indigo-600 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                                    </svg>
                                    Add to Cart
                                </button>
                                
                                {{-- You can add other buttons like "Buy Now" or "Add to Wishlist" here --}}
                            </div>
                        </form>
                    @else
                        <div class="mb-6">
                            <button disabled class="w-full bg-gray-400 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-white cursor-not-allowed">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                                </svg>
                                Out of Stock
                            </button>
                        </div>
                    @endif
                    
                    <div class="border-t border-gray-200 pt-6">
                        <div class="flex items-center text-sm text-gray-500 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                            Secure checkout with encrypted payment information
                        </div>
                        <div class="flex items-center text-sm text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1v-5h2a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7h-4v2h4V7z" />
                            </svg>
                            Free shipping on orders over Rp 1.500.000
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Related Products -->
            @if($relatedProducts->isNotEmpty())
                <div class="mt-16">
                    <h2 class="text-2xl font-bold text-gray-900 mb-8">Related Products</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($relatedProducts as $relatedProduct)
                            <div class="group bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200 hover:shadow-lg transition-all duration-300">
                                <a href="{{ route('products.show', $relatedProduct) }}" class="block relative aspect-w-4 aspect-h-3">
                                    @if($relatedProduct->image)
                                        <img src="{{ asset('storage/' . $relatedProduct->image) }}" alt="{{ $relatedProduct->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    @endif
                                </a>
                                
                                <div class="p-4">
                                    <a href="{{ route('products.show', $relatedProduct) }}" class="block">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-indigo-600 transition">
                                            {{ $relatedProduct->name }}
                                        </h3>
                                    </a>
                                    
                                    <div class="flex justify-between items-center">
                                        <span class="text-lg font-bold text-indigo-600">Rp {{ number_format($relatedProduct->price, 0, ',', '.') }}</span>
                                        
                                        <a href="{{ route('products.show', $relatedProduct) }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quantityInput = document.getElementById('quantity');
            const decrementButton = document.getElementById('decrementQuantity');
            const incrementButton = document.getElementById('incrementQuantity');
            
            if (quantityInput && decrementButton && incrementButton) {
                decrementButton.addEventListener('click', function() {
                    const currentValue = parseInt(quantityInput.value);
                    if (currentValue > 1) {
                        quantityInput.value = currentValue - 1;
                    }
                });
                
                incrementButton.addEventListener('click', function() {
                    const currentValue = parseInt(quantityInput.value);
                    const maxValue = parseInt(quantityInput.getAttribute('max'));
                    if (currentValue < maxValue) {
                        quantityInput.value = currentValue + 1;
                    }
                });
            }
        });
    </script>
    @endpush
</x-layouts.main>
