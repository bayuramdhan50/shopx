<x-layouts.main>
    <x-slot name="title">ShopX - Belanja Online Aman & Terpercaya</x-slot>

    <!-- Hero Banner Section -->
    <section class="bg-gray-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="swiper-container banner-swiper overflow-hidden rounded-xl shadow-lg" style="max-width: 100%; height: auto;">
                <div class="swiper-wrapper">
                    <!-- Banner 1 - Flash Sale -->
                    <div class="swiper-slide">
                        <div class="relative h-72 md:h-96 lg:h-[28rem] w-full bg-gradient-to-r from-indigo-600 via-indigo-500 to-sky-600 rounded-xl overflow-hidden">
                            <!-- Wave Background -->
                            <div class="absolute inset-0 z-0 opacity-20">
                                <svg class="absolute left-0 bottom-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                                    <path fill="#ffffff" fill-opacity="1" d="M0,192L48,176C96,160,192,128,288,138.7C384,149,480,203,576,224C672,245,768,235,864,208C960,181,1056,139,1152,133.3C1248,128,1344,160,1392,176L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
                                </svg>
                            </div>
                            
                            <!-- Animated Dots Pattern -->
                            <div class="absolute inset-0 z-0 opacity-10">
                                <div class="absolute inset-0" style="background-image: radial-gradient(white 1px, transparent 2px); background-size: 30px 30px;"></div>
                            </div>
                            
                            <!-- Content Container -->
                            <div class="absolute inset-0 flex items-center">
                                <div class="mx-8 md:mx-16 lg:mx-24 max-w-xl z-10">
                                    <!-- Badge -->
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs md:text-sm font-semibold bg-red-100 text-red-800 mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd" />
                                        </svg>
                                        PROMO SPESIAL
                                    </span>
                                    
                                    <!-- Heading -->
                                    <h2 class="text-3xl md:text-5xl font-extrabold text-white mb-4 leading-tight">
                                        Flash Sale! <br class="hidden md:block">
                                        <span class="text-yellow-300">Diskon hingga 40%</span>
                                    </h2>
                                    
                                    <!-- Description -->
                                    <p class="text-white text-lg mb-8 opacity-90 max-w-md">
                                        Dapatkan penawaran terbaik untuk produk elektronik terbaru dengan jaminan keamanan dan kualitas terbaik
                                    </p>
                                    
                                    <!-- CTA Button -->
                                    <a href="{{ route('products.index') }}" class="inline-flex items-center px-6 py-3 bg-white text-indigo-600 font-medium rounded-lg shadow-md hover:bg-indigo-50 transition duration-300 transform hover:scale-105">
                                        <span>Belanja Sekarang</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </div>
                                
                                <!-- Product Image -->
                                <div class="hidden md:block relative ml-auto h-full">
                                    <!-- Image Container with Shadow and Animation -->
                                    <div class="absolute right-0 h-full flex items-center pr-12 transform transition-all duration-500 hover:scale-105">
                                        <div class="relative">
                                            <div class="absolute -inset-4 bg-white opacity-10 rounded-3xl blur-xl"></div>
                                            <img 
                                                src="https://images.unsplash.com/photo-1546868871-7041f2a55e12?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" 
                                                alt="Electronics on Sale" 
                                                class="max-h-80 max-w-sm object-contain rounded-lg z-10 relative">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Banner 2 - New Products -->
                    <div class="swiper-slide">
                        <div class="relative h-72 md:h-96 lg:h-[28rem] w-full bg-gradient-to-r from-purple-700 via-purple-600 to-pink-600 rounded-xl overflow-hidden">
                            <!-- Wave Background -->
                            <div class="absolute inset-0 z-0 opacity-20">
                                <svg class="absolute left-0 bottom-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                                    <path fill="#ffffff" fill-opacity="1" d="M0,192L48,176C96,160,192,128,288,138.7C384,149,480,203,576,224C672,245,768,235,864,208C960,181,1056,139,1152,133.3C1248,128,1344,160,1392,176L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
                                </svg>
                            </div>
                            
                            <!-- Animated Circle Pattern -->
                            <div class="absolute inset-0 z-0 opacity-10">
                                <div class="absolute inset-0" style="background-image: radial-gradient(circle, white, transparent 8px); background-size: 60px 60px;"></div>
                            </div>
                            
                            <!-- Content Container -->
                            <div class="absolute inset-0 flex items-center">
                                <div class="mx-8 md:mx-16 lg:mx-24 max-w-xl z-10">
                                    <!-- Badge -->
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs md:text-sm font-semibold bg-blue-100 text-blue-800 mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        BARU DILUNCURKAN
                                    </span>
                                    
                                    <!-- Heading -->
                                    <h2 class="text-3xl md:text-5xl font-extrabold text-white mb-4 leading-tight">
                                        Produk Terbaru <br class="hidden md:block">
                                        <span class="text-pink-200">Teknologi 2025</span>
                                    </h2>
                                    
                                    <!-- Description -->
                                    <p class="text-white text-lg mb-8 opacity-90 max-w-md">
                                        Temukan teknologi terkini dengan fitur keamanan tingkat tinggi dan performa maksimal untuk kebutuhan Anda
                                    </p>
                                    
                                    <!-- CTA Button -->
                                    <a href="{{ route('products.index') }}" class="inline-flex items-center px-6 py-3 bg-white text-purple-600 font-medium rounded-lg shadow-md hover:bg-purple-50 transition duration-300 transform hover:scale-105">
                                        <span>Lihat Koleksi</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </div>
                                
                                <!-- Product Image -->
                                <div class="hidden md:block relative ml-auto h-full">
                                    <!-- Image Container with Glow Effect -->
                                    <div class="absolute right-0 h-full flex items-center pr-12 transform transition-all duration-500 hover:scale-105">
                                        <div class="relative">
                                            <div class="absolute -inset-4 bg-white opacity-10 rounded-3xl blur-xl"></div>
                                            <img 
                                                src="https://images.unsplash.com/photo-1593344484962-796055d4a3a4?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" 
                                                alt="New Technology Products" 
                                                class="max-h-80 max-w-sm object-contain rounded-lg z-10 relative">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Navigation Elements -->
                <div class="swiper-pagination"></div>
                
                <!-- Custom Navigation Buttons -->
                <div class="swiper-button-next after:content-[''] flex justify-center items-center w-10 h-10 bg-white bg-opacity-30 backdrop-blur-sm rounded-full text-white hover:bg-opacity-50 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="swiper-button-prev after:content-[''] flex justify-center items-center w-10 h-10 bg-white bg-opacity-30 backdrop-blur-sm rounded-full text-white hover:bg-opacity-50 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>
    </section>

    <!-- Category Section -->
    <section class="py-8 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Kategori Pilihan</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @php
                    $categories = \App\Models\Category::where('is_active', true)->take(6)->get();
                @endphp
                
                @foreach($categories as $category)
                <a href="{{ route('products.index', ['category' => json_encode($category)]) }}" class="flex flex-col items-center group">
                    <div class="w-20 h-20 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mb-2 group-hover:bg-indigo-200 transition-all">
                        <img src="{{ category_image($category->image) }}" alt="{{ $category->name }}" class="w-12 h-12 object-contain">
                    </div>
                    <span class="text-sm font-medium text-gray-700 text-center group-hover:text-indigo-600">{{ $category->name }}</span>
                </a>
                @endforeach

                <a href="{{ route('products.index') }}" class="flex flex-col items-center group">
                    <div class="w-20 h-20 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center mb-2 group-hover:bg-gray-200 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-700 text-center group-hover:text-indigo-600">Lihat Semua</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Flash Sale Section -->
    <section class="py-8 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd" />
                    </svg>
                    <h2 class="text-2xl font-bold text-gray-900">Flash Sale</h2>
                </div>
                <div class="flex items-center space-x-2 text-sm">
                    <span class="text-gray-600">Berakhir dalam:</span>
                    <span class="bg-gray-900 text-white px-2 py-1 rounded">23</span>
                    <span class="text-gray-600">:</span>
                    <span class="bg-gray-900 text-white px-2 py-1 rounded">59</span>
                    <span class="text-gray-600">:</span>
                    <span class="bg-gray-900 text-white px-2 py-1 rounded">59</span>
                </div>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                @php
                    $flashSaleProducts = \App\Models\Product::where('featured', true)->inRandomOrder()->take(6)->get();
                @endphp
                
                @foreach($flashSaleProducts as $product)
                <a href="{{ route('products.show', $product) }}" class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow group">
                    <div class="relative">
                        <img src="{{ product_image($product->image) }}" alt="{{ $product->name }}" class="w-full h-40 object-cover">
                        <div class="absolute top-0 left-0 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-br-lg">-{{ rand(10, 50) }}%</div>
                    </div>
                    <div class="p-3">
                        <h3 class="text-sm font-medium text-gray-900 mb-1 truncate group-hover:text-indigo-600">{{ $product->name }}</h3>
                        <div class="flex items-baseline space-x-2">
                            <span class="text-lg font-bold text-red-600">Rp {{ number_format($product->price * (rand(5, 9) / 10), 0, ',', '.') }}</span>
                            <span class="text-xs line-through text-gray-500">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="mt-2 h-2 bg-gray-200 rounded-full overflow-hidden">
                            @php $progress = rand(30, 90); @endphp
                            <div class="h-full bg-red-500" style="width: {{ $progress }}%"></div>
                        </div>
                        <div class="text-xs text-gray-600 mt-1">Tersisa {{ 100 - $progress }}%</div>
                    </div>
                </a>
                @endforeach
            </div>
            
            <div class="text-center mt-6">
                <a href="{{ route('products.index', ['sort' => 'price_low']) }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800">
                    Lihat Semua Promo
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Latest Products Section -->
    <section class="py-8 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Produk Terbaru</h2>
                <a href="{{ route('products.index', ['sort' => 'newest']) }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">Lihat Semua</a>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                @php
                    $latestProducts = \App\Models\Product::orderBy('created_at', 'desc')->take(10)->get();
                @endphp
                
                @foreach($latestProducts as $product)
                <a href="{{ route('products.show', $product) }}" class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow group">
                    <div class="relative overflow-hidden">
                        <img src="{{ product_image($product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                    </div>
                    
                    <div class="p-3">
                        <div class="flex items-center space-x-1 mb-1">
                            <span class="text-xs text-gray-600">{{ $product->category->name ?? 'Uncategorized' }}</span>
                        </div>
                        <h3 class="text-sm font-medium text-gray-900 mb-1 truncate group-hover:text-indigo-600">{{ $product->name }}</h3>
                        <div class="text-base font-bold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                        <div class="flex items-center mt-1 text-xs text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <span class="ml-1">{{ number_format(rand(35, 50) / 10, 1) }} | Terjual {{ rand(5, 120) }}</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Brand Categories -->
    <section class="py-8 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Brand Populer</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @php
                    $brands = \App\Models\Product::select('brand')->distinct()->take(12)->pluck('brand');
                @endphp
                
                @foreach($brands as $brand)
                <a href="{{ route('products.index', ['brand' => $brand]) }}" class="flex flex-col items-center group">
                    <div class="w-full h-20 bg-white rounded-lg shadow-sm flex items-center justify-center p-4 group-hover:shadow-md transition-all">
                        <span class="text-base font-semibold text-gray-800">{{ $brand }}</span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Recommended Products -->
    <section class="py-8 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Rekomendasi Untukmu</h2>
                <a href="{{ route('products.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">Lihat Semua</a>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                @php
                    $recommendedProducts = \App\Models\Product::inRandomOrder()->take(10)->get();
                @endphp
                
                @foreach($recommendedProducts as $product)
                <a href="{{ route('products.show', $product) }}" class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow group">
                    <div class="relative overflow-hidden">
                        <img src="{{ product_image($product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                    </div>
                    
                    <div class="p-3">
                        <div class="flex items-center space-x-1 mb-1">
                            <span class="text-xs text-gray-600">{{ $product->category->name ?? 'Uncategorized' }}</span>
                        </div>
                        <h3 class="text-sm font-medium text-gray-900 mb-1 truncate group-hover:text-indigo-600">{{ $product->name }}</h3>
                        <div class="text-base font-bold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                        <div class="flex items-center mt-1 text-xs text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <span class="ml-1">{{ number_format(rand(35, 50) / 10, 1) }} | Terjual {{ rand(5, 120) }}</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Download App Section -->
    <section class="py-12 bg-indigo-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-8">
                <div class="text-center md:text-left">
                    <h2 class="text-3xl font-bold text-white mb-4">Download Aplikasi ShopX</h2>
                    <p class="text-indigo-100 mb-6">Dapatkan pengalaman belanja yang lebih baik dengan aplikasi kami. Nikmati promo eksklusif dan keamanan berlapis.</p>
                    <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4 justify-center md:justify-start">
                        <a href="#" class="flex items-center justify-center space-x-3 bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.5 12c0 .3-.2.6-.4.8l-6.6 6.6c-.4.4-1 .4-1.4 0s-.4-1 0-1.4l5.9-5.9-5.9-5.9c-.4-.4-.4-1 0-1.4s1-.4 1.4 0l6.6 6.6c.2.1.4.4.4.7z"/>
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                            </svg>
                            <div>
                                <div class="text-xs">Download on the</div>
                                <div class="text-base font-semibold">App Store</div>
                            </div>
                        </a>
                        <a href="#" class="flex items-center justify-center space-x-3 bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M3.99 10.32l7.37-3.77.01 7.45-7.38-3.68zm7.36 3.9l.01 7.49-7.38-3.81 7.37-3.68zm.88-11.45L20 7.45l-7.77 4.03L4.32 7.46l7.91-4.69zM12.23 14.47L20 18.5l-7.77 4.02V14.47z"/>
                            </svg>
                            <div>
                                <div class="text-xs">GET IT ON</div>
                                <div class="text-base font-semibold">Google Play</div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="hidden md:block">
                    <img src="https://images.unsplash.com/photo-1616348436168-de43ad0db179?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Mobile App" class="w-full max-w-sm mx-auto rounded-lg shadow-xl">
                </div>
            </div>
        </div>
    </section>

    <!-- Swiper JS for banner carousel -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new Swiper('.banner-swiper', {
                slidesPerView: 1,
                spaceBetween: 0,
                loop: true,
                // effect: "fade", // Menggunakan efek fade agar transisi lebih halus
                // fadeEffect: {
                //     crossFade: true // Efek cross-fade antar slide
                // },
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        });
    </script>

    <!-- Featured Products Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">Featured Products</h2>
            
            @if($featuredProducts->isEmpty())
                <div class="text-center py-8">
                    <p class="text-gray-500">No featured products available at the moment.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($featuredProducts as $product)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition duration-300">
                            <a href="{{ route('products.show', $product) }}">
                                @if($product->image)
                                    <img src="{{ product_image($product->image) }}" alt="{{ $product->name }}" class="w-full h-64 object-cover">
                                @else
                                    <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                @endif
                            </a>
                            <div class="p-5">
                                <a href="{{ route('products.show', $product) }}" class="block">
                                    <h3 class="text-lg font-semibold text-gray-800 hover:text-indigo-600 mb-2">{{ $product->name }}</h3>
                                </a>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $product->description }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-indigo-600 font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    <a href="{{ route('products.show', $product) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm hover:bg-indigo-700 transition">View Details</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-10">
                    <a href="{{ route('products.index') }}" class="px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition duration-300">View All Products</a>
                </div>
            @endif
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">Why Choose ShopX?</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-xl shadow-md text-center">
                    <div class="w-16 h-16 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Secure Encryption</h3>
                    <p class="text-gray-600">All your personal and payment information is encrypted using AES-256 encryption technology.</p>
                </div>
                
                <div class="bg-white p-8 rounded-xl shadow-md text-center">
                    <div class="w-16 h-16 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Quality Products</h3>
                    <p class="text-gray-600">We source only the best electronics from trusted manufacturers with proper warranties.</p>
                </div>
                
                <div class="bg-white p-8 rounded-xl shadow-md text-center">
                    <div class="w-16 h-16 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Secure Payments</h3>
                    <p class="text-gray-600">We integrate with Midtrans to ensure secure and reliable payment processing.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">What Our Customers Say</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-gray-50 p-8 rounded-xl shadow-sm">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center mr-4">
                            <span class="text-indigo-600 font-bold">BS</span>
                        </div>
                        <div>
                            <h4 class="font-semibold">Budi Santoso</h4>
                            <div class="flex text-yellow-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600">"I love how secure I feel when shopping at ShopX. The encryption of my personal data gives me peace of mind, and the products are top-notch!"</p>
                </div>
                
                <div class="bg-gray-50 p-8 rounded-xl shadow-sm">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center mr-4">
                            <span class="text-indigo-600 font-bold">SW</span>
                        </div>
                        <div>
                            <h4 class="font-semibold">Siti Wulandari</h4>
                            <div class="flex text-yellow-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600">"The checkout process with Midtrans was smooth and secure. I received my gaming laptop in perfect condition and it works amazingly well!"</p>
                </div>
                
                <div class="bg-gray-50 p-8 rounded-xl shadow-sm">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center mr-4">
                            <span class="text-indigo-600 font-bold">AP</span>
                        </div>
                        <div>
                            <h4 class="font-semibold">Ahmad Pratama</h4>
                            <div class="flex text-yellow-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600">"Fast shipping, great customer service, and the website is so easy to use. I especially appreciate the security measures they take with my data."</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-20 bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-6">Ready to Experience Secure Shopping?</h2>
            <p class="text-xl mb-8 max-w-3xl mx-auto">Join thousands of satisfied customers who trust ShopX for their electronic needs with the peace of mind that comes from knowing your data is secure.</p>
            <div class="space-x-4">
                <a href="{{ route('register') }}" class="px-8 py-4 bg-white text-indigo-600 font-medium rounded-lg shadow-md hover:bg-indigo-50 transition duration-300">Create Account</a>
                <a href="{{ route('products.index') }}" class="px-8 py-4 border border-white text-white font-medium rounded-lg hover:bg-white hover:bg-opacity-10 transition duration-300">Browse Products</a>
            </div>
        </div>
    </section>
</x-layouts.main>
