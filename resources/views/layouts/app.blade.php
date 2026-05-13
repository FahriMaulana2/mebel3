<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Kiana Furniture')</title>
    
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brown: { 500: '#8B5E3C', 600: '#7a5235' },
                        gold: { 400: '#C6A43F' }
                    },
                    fontFamily: {
                        playfair: ['Playfair Display', 'serif'],
                        inter: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    @stack('styles')
</head>

<body class="font-inter bg-white">

<div id="app">

    {{-- Navbar --}}
    @include('layouts.partials.navbar')

    {{-- Content --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('layouts.partials.footer')

    {{-- Back to Top --}}
    <button id="backToTop"
        class="fixed bottom-8 right-8 bg-brown-600 text-white w-12 h-12 rounded-full shadow-lg hidden">
        ↑
    </button>

</div>

{{-- Scripts --}}
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // Init AOS
    AOS.init({
        duration: 800,
        once: true
    });

    // Back to Top
    const btn = document.getElementById('backToTop');

    window.addEventListener('scroll', function () {
        if (window.scrollY > 300) {
            btn.classList.remove('hidden');
        } else {
            btn.classList.add('hidden');
        }
    });

    btn.addEventListener('click', function () {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    // Update cart badge kalau ada
    if (typeof updateCartBadge === 'function') {
        updateCartBadge();
    }

});
</script>

{{-- 🔥 STACK SCRIPT --}}
@stack('scripts')

<!-- 🔥 WAJIB: CART GLOBAL -->
<script src="{{ asset('js/cart.js') }}"></script>

</body>
</html>