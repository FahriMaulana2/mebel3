<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin') - Kiana Furniture Admin</title>

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .sidebar-item:hover {
            background-color: #8B5E3C;
            color: white;
        }

        .sidebar-item.active {
            background-color: #8B5E3C;
            color: white;
        }
    </style>
</head>

<body class="bg-gray-100">

<div class="flex h-screen">

    <!-- SIDEBAR -->
    <aside class="w-72 bg-gray-900 text-white flex-shrink-0 overflow-y-auto">

        <!-- LOGO -->
        <div class="p-6 border-b border-gray-800">

            <h1 class="text-2xl font-bold">
                Kiana<span class="text-yellow-500">Admin</span>
            </h1>

            <p class="text-gray-500 text-sm mt-1">
                Furniture Dashboard
            </p>

        </div>

        <!-- NAVIGATION -->
        <nav class="p-4">

            <div class="mb-6">

                <p class="text-gray-500 text-xs uppercase mb-3">
                    Main Menu
                </p>

                <!-- DASHBOARD -->
                <a href="{{ route('admin.dashboard') }}"
                   class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg transition mb-1
                   {{ request()->routeIs('admin.dashboard') ? 'active' : 'text-gray-300 hover:bg-gray-800' }}">

                    <i class="fas fa-tachometer-alt w-5"></i>
                    Dashboard
                </a>

                <!-- PRODUCTS -->
                <a href="{{ route('admin.products.index') }}"
                   class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg transition mb-1
                   {{ request()->routeIs('admin.products.*') ? 'active' : 'text-gray-300 hover:bg-gray-800' }}">

                    <i class="fas fa-box w-5"></i>
                    Products
                </a>

                <!-- BRANDS -->
                <a href="{{ route('admin.brands.index') }}"
                   class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg transition mb-1
                   {{ request()->routeIs('admin.brands.*') ? 'active' : 'text-gray-300 hover:bg-gray-800' }}">

                    <i class="fas fa-tag w-5"></i>
                    Brands
                </a>

                <!-- VOUCHERS -->
                <a href="{{ route('admin.vouchers.index') }}"
                   class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg transition mb-1
                   {{ request()->routeIs('admin.vouchers.*') ? 'active' : 'text-gray-300 hover:bg-gray-800' }}">

                    <i class="fas fa-ticket-alt w-5"></i>
                    Vouchers
                </a>

                <!-- ORDERS -->
                <a href="{{ route('admin.orders.index') }}"
                   class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg transition mb-1
                   {{ request()->routeIs('admin.orders.*') ? 'active' : 'text-gray-300 hover:bg-gray-800' }}">

                    <i class="fas fa-shopping-cart w-5"></i>
                    Orders
                </a>

                <!-- PAYMENTS -->
                <a href="{{ route('admin.payments.index') }}"
                   class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg transition mb-1
                   {{ request()->routeIs('admin.payments.*') ? 'active' : 'text-gray-300 hover:bg-gray-800' }}">

                    <i class="fas fa-credit-card w-5"></i>
                    Payments
                </a>

                <!-- SHIPMENTS -->
                <a href="{{ route('admin.shipments.index') }}"
                   class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg transition mb-1
                   {{ request()->routeIs('admin.shipments.*') ? 'active' : 'text-gray-300 hover:bg-gray-800' }}">

                    <i class="fas fa-truck w-5"></i>
                    Shipments
                </a>

            </div>

            <!-- ACCOUNT -->
            <div class="pt-6 border-t border-gray-800">

                <p class="text-gray-500 text-xs uppercase mb-3">
                    Account
                </p>

                <!-- USER -->
                <div class="px-4 py-3 rounded-lg bg-gray-800 mb-2">

                    <div class="flex items-center gap-3">

                        <div class="w-8 h-8 bg-yellow-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-white text-sm"></i>
                        </div>

                        <div>
                            <p class="text-sm font-medium">
                                {{ auth()->user()->name }}
                            </p>

                            <p class="text-xs text-gray-500">
                                {{ auth()->user()->email }}
                            </p>
                        </div>

                    </div>

                </div>

                <!-- VIEW WEBSITE -->
                <a href="{{ url('/') }}"
                   target="_blank"
                   class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg transition mb-2 text-gray-300 hover:bg-gray-800">

                    <i class="fas fa-external-link-alt w-5"></i>
                    View Website
                </a>

                <!-- LOGOUT -->
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf

                    <button type="submit"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-red-600 hover:text-white transition">

                        <i class="fas fa-sign-out-alt w-5"></i>
                        Logout

                    </button>
                </form>

            </div>

        </nav>

    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 overflow-y-auto">

        <!-- TOPBAR -->
        <div class="bg-white shadow-sm px-6 py-4 flex justify-between items-center sticky top-0 z-10">

            <h2 class="text-xl font-semibold text-gray-800">
                @yield('title')
            </h2>

            <div class="text-sm text-gray-500">
                {{ date('d M Y') }}
            </div>

        </div>

        <!-- CONTENT -->
        <div class="p-6">

            @yield('content')

        </div>

    </main>

</div>

{{-- SweetAlert2 Global Alerts --}}
<x-alerts />

</body>
</html>