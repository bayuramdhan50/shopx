<x-layouts.main>
    <x-slot name="title">All Products</x-slot>

    <div class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Browse All Products</h1>

            <!-- Filters & Search Section -->
            <div class="mb-8 bg-gray-50 rounded-lg p-6 shadow-sm">
                <form action="{{ route('products.index') }}" method="get" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                        <input type="text" name="search" id="search" placeholder="Search by name, brand..." 
                            value="{{ request('search') }}" 
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select id="category" name="category" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ json_encode($category) }}" {{ request('category') == json_encode($category) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="brand" class="block text-sm font-medium text-gray-700 mb-1">Brand</label>
                        <select id="brand" name="brand" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">All Brands</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>
                                    {{ $brand }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                        <select id="sort" name="sort" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-indigo-600 border border-transparent rounded-md py-2 px-4 flex items-center justify-center text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Products Grid -->
            @if($products->isEmpty())
                <div class="text-center py-12 bg-gray-50 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900">No products found</h3>
                    <p class="mt-2 text-gray-500">Try adjusting your search or filter to find what you're looking for.</p>
                    <a href="{{ route('products.index') }}" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Clear Filters
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <div class="group bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200 hover:shadow-lg transition-all duration-300">
                            <a href="{{ route('products.show', $product) }}" class="block relative aspect-w-4 aspect-h-3">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                @endif
                                
                                <!-- Stock Badge -->
                                @if($product->stock > 0)
                                    <span class="absolute top-2 right-2 px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded">
                                        In Stock
                                    </span>
                                @else
                                    <span class="absolute top-2 right-2 px-2 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded">
                                        Out of Stock
                                    </span>
                                @endif
                            </a>
                            
                            <div class="p-4">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm text-indigo-600 font-medium">{{ $product->category->name ?? 'Uncategorized' }}</span>
                                    <span class="text-sm text-gray-500">{{ $product->brand }}</span>
                                </div>
                                
                                <a href="{{ route('products.show', $product) }}" class="block">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-indigo-600 transition">
                                        {{ $product->name }}
                                    </h3>
                                </a>
                                
                                <p class="text-gray-500 text-sm mb-4 line-clamp-2">
                                    {{ $product->description }}
                                </p>
                                
                                <div class="flex justify-between items-center">
                                    <span class="text-xl font-bold text-indigo-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    
                                    <a href="{{ route('products.show', $product) }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-8">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.main>
