<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - Mebelku</title>
    
    <!-- Fonts - Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        :root {
            --primary: #C08B5C;
            --primary-dark: #A07A4C;
            --secondary: #F5F1EB;
            --dark: #1F2937;
            --text: #4B5563;
            --text-light: #6B7280;
            --border: #E5E7EB;
            --background: #FAFAF9;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
        }
        
        /* Sidebar styles */
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            color: #9CA3AF;
            transition: all 0.2s ease;
        }
        
        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }
        
        .sidebar-link.active {
            background: var(--primary);
            color: white;
        }
        
        /* Card styles */
        .card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--border);
        }
        
        .stat-card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--border);
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }
        
        /* Button styles */
        .btn-primary {
            background: var(--primary);
            color: white;
            padding: 0.625rem 1.25rem;
            border-radius: 0.75rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }
        
        .btn-outline {
            border: 1px solid var(--border);
            color: var(--text);
            padding: 0.625rem 1.25rem;
            border-radius: 0.75rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-outline:hover {
            border-color: var(--primary);
            color: var(--primary);
        }
        
        /* Table styles */
        .table-container {
            background: white;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--border);
        }
        
        .table-container table {
            width: 100%;
        }
        
        .table-container th {
            background: var(--secondary);
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: var(--text);
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .table-container td {
            padding: 1rem;
            border-bottom: 1px solid var(--border);
        }
        
        .table-container tr:hover {
            background: var(--secondary);
        }
        
        /* Input styles */
        .input-field {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border);
            border-radius: 0.75rem;
            font-size: 0.875rem;
            transition: all 0.3s ease;
        }
        
        .input-field:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(192, 139, 92, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-dark flex flex-col">
            <!-- Logo -->
            <div class="p-6 border-b border-white/10">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center">
                        <i class="fas fa-couch text-white"></i>
                    </div>
                    <span class="text-xl font-bold text-white">Mebelku</span>
                </a>
            </div>
            
            <!-- Navigation -->
            <nav class="flex-1 p-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" 
                   class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-th-large w-5"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.brands.index') }}" 
                   class="sidebar-link {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">
                    <i class="fas fa-tag w-5"></i>
                    <span>Brands</span>
                </a>
                <a href="{{ route('admin.products.index') }}" 
                   class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="fas fa-box w-5"></i>
                    <span>Products</span>
                </a>
                <a href="{{ route('admin.orders.index') }}" 
                   class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-bag w-5"></i>
                    <span>Orders</span>
                </a>
                <a href="{{ route('admin.payments.index') }}" 
                   class="sidebar-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                    <i class="fas fa-credit-card w-5"></i>
                    <span>Payments</span>
                </a>
                <a href="{{ route('admin.shipments.index') }}" 
                   class="sidebar-link {{ request()->routeIs('admin.shipments.*') ? 'active' : '' }}">
                    <i class="fas fa-truck w-5"></i>
                    <span>Shipments</span>
                </a>
                
                <div class="pt-4 mt-4 border-t border-white/10">
                    <a href="{{ route('home') }}" class="sidebar-link">
                        <i class="fas fa-external-link-alt w-5"></i>
                        <span>View Site</span>
                    </a>
                </div>
            </nav>
            
            <!-- User -->
            <div class="p-4 border-t border-white/10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-primary/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-primary"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-white text-sm font-medium">{{ auth()->user()->name ?? 'Admin' }}</p>
                        <p class="text-gray-400 text-xs">Administrator</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white border-b border-border p-4 flex justify-between items-center">
                <h1 class="text-xl font-semibold text-dark">@yield('header', 'Dashboard')</h1>
                
                <div class="flex items-center gap-4">
                    <span class="text-sm text-text-light">{{ date('l, F j, Y') }}</span>
                </div>
            </header>
            
            <!-- Content -->
            <main class="flex-1 overflow-auto p-6">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
