<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - Kiana Furniture Admin</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-item:hover { background-color: #8B5E3C; color: white; }
        .sidebar-item.active { background-color: #8B5E3C; color: white; }
        .table-row:hover { background-color: #f9fafb; }
    </style>
</head>
<body class="bg-gray-100">

<div class="flex h-screen">
    <!-- Sidebar -->
    <aside class="w-72 bg-gray-900 text-white flex-shrink-0 overflow-y-auto">
        <div class="p-6 border-b border-gray-800">
            <h1 class="text-2xl font-bold">Kiana<span class="text-brown-600">Admin</span></h1>
            <p class="text-gray-500 text-sm mt-1">Furniture Dashboard</p>
        </div>
        
        <nav class="p-4">
            <div class="mb-6">
                <p class="text-gray-500 text-xs uppercase tracking-wider mb-3">Main Menu</p>
                <a href="{{ route('admin.dashboard') }}" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg transition mb-1 {{ request()->routeIs('admin.dashboard') ? 'active' : 'text-gray-300 hover:bg-gray-800' }}">
                    <i class="fas fa-tachometer-alt w-5"></i> Dashboard
                </a>
                <a href="{{ route('admin.products.index') }}" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg transition mb-1 {{ request()->routeIs('admin.products.*') ? 'active' : 'text-gray-300 hover:bg-gray-800' }}">
                    <i class="fas fa-box w-5"></i> Products
                </a>
                <a href="{{ route('admin.brands.index') }}" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg transition mb-1 {{ request()->routeIs('admin.brands.*') ? 'active' : 'text-gray-300 hover:bg-gray-800' }}">
                    <i class="fas fa-tag w-5"></i> Brands
                </a>
                <a href="{{ route('admin.orders.index') }}" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg transition mb-1 {{ request()->routeIs('admin.orders.*') ? 'active' : 'text-gray-300 hover:bg-gray-800' }}">
                    <i class="fas fa-shopping-cart w-5"></i> Orders
                </a>
                <a href="{{ route('admin.payments.index') }}" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg transition mb-1 {{ request()->routeIs('admin.payments.*') ? 'active' : 'text-gray-300 hover:bg-gray-800' }}">
                    <i class="fas fa-credit-card w-5"></i> Payments
                </a>
                <a href="{{ route('admin.shipments.index') }}" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg transition mb-1 {{ request()->routeIs('admin.shipments.*') ? 'active' : 'text-gray-300 hover:bg-gray-800' }}">
                    <i class="fas fa-truck w-5"></i> Shipments
                </a>
            </div>
            
            <div class="pt-6 border-t border-gray-800">
                <p class="text-gray-500 text-xs uppercase tracking-wider mb-3">Account</p>
                <div class="px-4 py-3 rounded-lg bg-gray-800 mb-2">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-brown-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-white text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-red-600 hover:text-white transition">
                        <i class="fas fa-sign-out-alt w-5"></i> Logout
                    </button>
                </form>
            </div>
        </nav>
    </aside>
    
    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto">
        <div class="bg-white shadow-sm px-6 py-4 flex justify-between items-center sticky top-0 z-10">
            <h2 class="text-xl font-semibold text-gray-800">@yield('title')</h2>
            <div class="flex items-center gap-3">
                <a href="{{ url('/') }}" target="_blank" class="text-gray-600 hover:text-brown-600">
                    <i class="fas fa-external-link-alt"></i> View Website
                </a>
            </div>
        </div>
        
        <div class="p-6">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                    {{ session('error') }}
                </div>
            @endif
            
            @yield('content')
        </div>
    </main>
</div>

</body>
</html>