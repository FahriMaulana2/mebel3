<nav x-data="{ mobileMenuOpen: false, searchOpen: false, authDropdown: false }"
     class="fixed top-0 left-0 w-full bg-white/95 backdrop-blur-xl border-b border-gray-100 shadow-sm z-50">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex items-center justify-between h-20">

            <!-- LOGO -->
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">

                <div class="w-11 h-11 rounded-2xl bg-brown-600 flex items-center justify-center shadow-lg group-hover:scale-105 transition duration-300">
                    <i class="fas fa-chair text-white text-lg"></i>
                </div>

                <div class="leading-tight">
                    <h1 class="text-2xl font-black text-gray-900">
                        Kiana<span class="text-brown-600">Furniture</span>
                    </h1>
                </div>

            </a>

            <!-- DESKTOP MENU -->
            <div class="hidden lg:flex items-center gap-2">

                <a href="{{ url('/') }}"
                   class="px-4 py-2 rounded-xl text-gray-700 hover:bg-brown-50 hover:text-brown-600 transition font-medium">
                    Home
                </a>

                <a href="{{ route('products.index') }}"
                   class="px-4 py-2 rounded-xl text-gray-700 hover:bg-brown-50 hover:text-brown-600 transition font-medium">
                    Products
                </a>

                <a href="{{ url('/#company-history') }}"
                   class="px-4 py-2 rounded-xl text-gray-700 hover:bg-brown-50 hover:text-brown-600 transition font-medium">
                    Company History
                </a>

                <a href="{{ url('/#contact') }}"
                   class="px-4 py-2 rounded-xl text-gray-700 hover:bg-brown-50 hover:text-brown-600 transition font-medium">
                    Contact
                </a>

            </div>

            <!-- SEARCH -->
            <div class="hidden lg:flex flex-1 max-w-sm mx-8">

                <div class="relative w-full">

                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>

                    <input type="text"
                           id="search-input-desktop"
                           placeholder="Search furniture..."
                           class="w-full pl-11 pr-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-brown-100 focus:border-brown-600 transition">

                </div>

            </div>

            <!-- RIGHT MENU -->
            <div class="flex items-center gap-3">

                <!-- MOBILE SEARCH -->
                <button @click="searchOpen = !searchOpen"
                        class="lg:hidden w-10 h-10 rounded-xl hover:bg-brown-50 text-gray-700 hover:text-brown-600 transition">

                    <i class="fas fa-search"></i>

                </button>

                <!-- CART -->
                <a href="{{ route('cart.index') }}"
                   class="relative w-11 h-11 rounded-xl hover:bg-brown-50 flex items-center justify-center text-gray-700 hover:text-brown-600 transition">

                    <i class="fas fa-shopping-bag text-lg"></i>

                    <span id="cart-badge"
                          class="absolute -top-1 -right-1 w-5 h-5 bg-brown-600 text-white text-[10px] rounded-full flex items-center justify-center hidden">
                        0
                    </span>

                </a>

                <!-- USER AUTH -->
                @auth

                <div class="relative">

                    <button @click="authDropdown = !authDropdown"
                            class="flex items-center gap-2 bg-gray-100 hover:bg-brown-50 px-3 py-2 rounded-2xl transition">

                        <div class="w-10 h-10 rounded-xl bg-brown-600 flex items-center justify-center text-white">
                            <i class="fas fa-user"></i>
                        </div>

                        <div class="hidden md:block text-left">
                            <p class="text-sm font-semibold text-gray-800 leading-none">
                                {{ auth()->user()->name }}
                            </p>
                            <span class="text-xs text-gray-500">
                                Account
                            </span>
                        </div>

                        <i class="fas fa-chevron-down text-xs text-gray-500"></i>

                    </button>

                    <!-- DROPDOWN -->
                    <div x-show="authDropdown"
                         @click.away="authDropdown = false"
                         x-transition
                         class="absolute right-0 mt-4 w-64 bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden"
                         style="display:none;">

                        <div class="p-5 bg-brown-600 text-white">

                            <p class="font-bold">
                                {{ auth()->user()->name }}
                            </p>

                            <p class="text-sm text-white/80">
                                {{ auth()->user()->email }}
                            </p>

                        </div>

                        <div class="p-2">

                            <a href="{{ route('orders.index') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-brown-50 text-gray-700 hover:text-brown-600 transition">

                                <i class="fas fa-box"></i>
                                My Orders

                            </a>

                            @if(auth()->user()->is_admin)

                            <a href="{{ route('admin.dashboard') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-brown-50 text-gray-700 hover:text-brown-600 transition">

                                <i class="fas fa-chart-line"></i>
                                Admin Dashboard

                            </a>

                            @endif

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <button type="submit"
                                        class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-red-50 text-red-600 transition">

                                    <i class="fas fa-sign-out-alt"></i>
                                    Logout

                                </button>

                            </form>

                        </div>

                    </div>

                </div>

                @else

                <!-- GUEST MENU -->
                <div class="relative">

                    <button @click="authDropdown = !authDropdown"
                            class="w-11 h-11 rounded-2xl bg-brown-600 text-white shadow-lg hover:scale-105 transition duration-300">

                        <i class="fas fa-user"></i>

                    </button>

                    <!-- DROPDOWN -->
                    <div x-show="authDropdown"
                         @click.away="authDropdown = false"
                         x-transition
                         class="absolute right-0 mt-4 w-56 bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden"
                         style="display:none;">

                        <div class="p-5 bg-brown-600 text-white">

                            <h3 class="font-bold text-lg">
                                Welcome
                            </h3>

                            <p class="text-sm text-white/80">
                                Login untuk mulai berbelanja
                            </p>

                        </div>

                        <div class="p-3 space-y-2">

                            <a href="{{ route('login') }}"
                               class="flex items-center justify-center gap-2 w-full py-3 rounded-2xl bg-brown-600 hover:bg-brown-700 text-white font-semibold transition">

                                <i class="fas fa-sign-in-alt"></i>
                                Sign In

                            </a>

                            <a href="{{ route('register') }}"
                               class="flex items-center justify-center gap-2 w-full py-3 rounded-2xl border border-brown-600 text-brown-600 hover:bg-brown-50 font-semibold transition">

                                <i class="fas fa-user-plus"></i>
                                Register

                            </a>

                        </div>

                    </div>

                </div>

                @endauth

                <!-- MOBILE MENU BUTTON -->
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="lg:hidden w-10 h-10 rounded-xl hover:bg-brown-50 text-gray-700 hover:text-brown-600 transition">

                    <i x-show="!mobileMenuOpen" class="fas fa-bars text-lg"></i>

                    <i x-show="mobileMenuOpen"
                       class="fas fa-times text-lg"
                       style="display:none;"></i>

                </button>

            </div>

        </div>

        <!-- MOBILE SEARCH -->
        <div x-show="searchOpen"
             x-transition
             class="lg:hidden pb-4"
             style="display:none;">

            <div class="relative">

                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>

                <input type="text"
                       id="search-input-mobile"
                       placeholder="Search furniture..."
                       class="w-full pl-11 pr-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-brown-100 focus:border-brown-600">

            </div>

        </div>

        <!-- MOBILE MENU -->
        <div x-show="mobileMenuOpen"
             x-transition
             class="lg:hidden pb-5"
             style="display:none;">

            <div class="bg-white rounded-3xl border border-gray-100 shadow-lg p-3 space-y-2">

                <a href="{{ url('/') }}"
                   class="block px-4 py-3 rounded-2xl hover:bg-brown-50 hover:text-brown-600 text-gray-700 transition">
                    Home
                </a>

                <a href="{{ route('products.index') }}"
                   class="block px-4 py-3 rounded-2xl hover:bg-brown-50 hover:text-brown-600 text-gray-700 transition">
                    Products
                </a>

                <a href="{{ url('/#company-history') }}"
                   class="block px-4 py-3 rounded-2xl hover:bg-brown-50 hover:text-brown-600 text-gray-700 transition">
                    Company History
                </a>

                <a href="{{ url('/#contact') }}"
                   class="block px-4 py-3 rounded-2xl hover:bg-brown-50 hover:text-brown-600 text-gray-700 transition">
                    Contact
                </a>

                @guest

                <div class="border-t pt-3 mt-3 space-y-2">

                    <a href="{{ route('login') }}"
                       class="block text-center py-3 rounded-2xl bg-brown-600 text-white font-semibold">
                        Sign In
                    </a>

                    <a href="{{ route('register') }}"
                       class="block text-center py-3 rounded-2xl border border-brown-600 text-brown-600 font-semibold hover:bg-brown-50">
                        Register
                    </a>

                </div>

                @endguest

            </div>

        </div>

    </div>

</nav>

<!-- SPACER -->
<div class="h-20"></div>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>

<script>
    function performSearch() {

        const query =
            document.getElementById('search-input-desktop')?.value ||
            document.getElementById('search-input-mobile')?.value;

        if (query && query.length > 0) {

            window.location.href =
                '{{ route("products.index") }}?search=' +
                encodeURIComponent(query);

        }
    }

    document.getElementById('search-input-desktop')
        ?.addEventListener('keypress', function(e) {

            if (e.key === 'Enter') {
                performSearch();
            }

        });

    document.getElementById('search-input-mobile')
        ?.addEventListener('keypress', function(e) {

            if (e.key === 'Enter') {
                performSearch();
            }

        });
</script>