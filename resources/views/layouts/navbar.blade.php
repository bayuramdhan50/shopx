<!-- Top Bar -->
        <div class="bg-indigo-800 text-white text-xs py-2 hidden sm:block">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between">
                    <div class="flex space-x-4">
                        <a href="#" class="hover:text-indigo-200">Download App</a>
                        <span class="text-indigo-400">|</span>
                        <a href="{{ route("about") }}" class="hover:text-indigo-200">Tentang Kami</a>
                        <span class="text-indigo-400">|</span>
                        <a href="{{ route('contact') }}" class="hover:text-indigo-200">Bantuan</a>
                    </div>
                    @auth
                        <div class="flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>Selamat datang, {{ Auth::user()->name }}</span>
                        </div>
                    @endauth
                </div>
            </div>
        </div>

<!-- Temporary fix for navbar -->
<nav x-data="{ open: false, searchFocus: false }" class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo and Search -->
            <div class="flex-1 flex items-center">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-indigo-600 font-bold text-xl">
                        <span class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-indigo-600">Shop</span><span class="text-indigo-800">X</span>
                        </span>
                    </a>
                </div>

                <!-- Search Section -->
                <div class="ml-6 flex-1 max-w-xl">
                    <form action="{{ route('products.index') }}" method="GET" class="w-full">
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input type="text" name="search" id="search"
                                @focus="searchFocus = true"
                                @blur="searchFocus = false"
                                :class="{ 'border-indigo-500 ring-2 ring-indigo-200': searchFocus }"
                                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 sm:text-sm transition duration-150 ease-in-out"
                                placeholder="Cari produk, brand, kategori..."
                                value="{{ request('search') }}"/>
                            <button type="submit" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <span class="text-xs text-gray-400">Cari</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="hidden sm:flex sm:items-center sm:space-x-8">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('home') ? 'text-indigo-600' : '' }}">
                    Beranda
                </a>
                <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('products.*') ? 'text-indigo-600' : '' }}">
                    Semua Produk
                </a>
            </div>

            <!-- Right navigation -->
            <div class="flex items-center space-x-4">
                <!-- Shopping Cart -->
                <a href="{{ route('cart.index') }}" class="relative text-gray-600 hover:text-indigo-600 p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    @php
                        $cartCount = Auth::check() ? \App\Models\CartItem::where('user_id', Auth::id())->sum('quantity') : 0;
                    @endphp
                    @if($cartCount > 0)
                        <span class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ $cartCount }}</span>
                    @endif
                </a>

                <!-- User Menu -->
                @auth
                    <div class="hidden sm:flex sm:items-center sm:ml-6" x-data="{ open: false }">
                        <div class="relative">
                            <button @click="open = !open" class="flex items-center text-sm font-medium text-gray-700 hover:text-indigo-600 focus:outline-none transition duration-150 ease-in-out">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span>Akun Saya</span>
                                </div>
                                <svg class="ml-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div x-show="open"
                                @click.away="open = false"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-48 py-2 bg-white rounded-md shadow-xl z-50"
                                style="display: none;">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">Profil</a>
                                <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">Pesanan Saya</a>
                                <a href="{{ route('payment-methods.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">Metode Pembayaran</a>
                                <a href="{{ route("about") }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">Tentang Kami</a>
                                <a href="{{ route("contact") }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">Kontak</a>
                                @if(Auth::user()->is_admin)
                                    <a href="{{ route('filament.admin.pages.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">Admin Dashboard</a>
                                @endif

                                <hr class="my-1 border-gray-200">

                                <form method="POST" action="{{ route('logout') }}" class="block w-full text-left">
                                    @csrf
                                    <button type="submit" class="w-full px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">Keluar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="hidden sm:flex space-x-2">
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">Masuk</a>
                        <a href="{{ route('register') }}" class="bg-indigo-600 text-white hover:bg-indigo-700 px-3 py-2 rounded-md text-sm font-medium">Daftar</a>
                    </div>
                @endauth

                <!-- Mobile menu button -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('home') }}" class="block pl-3 pr-4 py-2 border-l-4 border-indigo-500 text-indigo-700 bg-indigo-50 focus:outline-none focus:bg-indigo-100 transition duration-150 ease-in-out">Beranda</a>
            <a href="{{ route('products.index') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out">Semua Produk</a>
            <a href="{{ route('cart.index') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out">Keranjang
                @if($cartCount > 0)
                    <span class="ml-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">{{ $cartCount }}</span>
                @endif
            </a>
        </div>

        <!-- Mobile Authentication Links -->
        <div class="pt-4 pb-3 border-t border-gray-200">
            @auth
                <div class="flex items-center px-4">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center text-white">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('orders.index')">
                        {{ __('My Orders') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('payment-methods.index')">
                        {{ __('Payment Methods') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="'#'">
                        {{ __('About Us') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="'#'">
                        {{ __('Contact') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('Login') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')">
                        {{ __('Register') }}
                    </x-responsive-nav-link>
                </div>
            @endauth
        </div>
    </div>
</nav>
