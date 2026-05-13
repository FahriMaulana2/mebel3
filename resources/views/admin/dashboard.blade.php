@extends('admin.layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Dashboard Overview
            </h1>
            <p class="text-gray-500 mt-1">
                Selamat datang di panel admin toko furniture
            </p>
        </div>

        <div class="mt-4 md:mt-0">
            <div class="bg-white shadow-sm border rounded-xl px-4 py-2 text-sm text-gray-600">
                {{ now()->format('d M Y') }}
            </div>
        </div>
    </div>

    <!-- MAIN STATS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">

        <!-- PRODUCTS -->
        <div class="bg-white rounded-2xl shadow-sm border p-6 hover:shadow-lg transition duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Products</p>
                    <h2 class="text-3xl font-bold text-gray-800 mt-1">
                        {{ $totalProducts ?? 0 }}
                    </h2>
                </div>

                <div class="w-14 h-14 rounded-2xl bg-orange-100 flex items-center justify-center">
                    <i class="fas fa-box text-orange-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- ORDERS -->
        <div class="bg-white rounded-2xl shadow-sm border p-6 hover:shadow-lg transition duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Orders</p>
                    <h2 class="text-3xl font-bold text-gray-800 mt-1">
                        {{ $totalOrders ?? 0 }}
                    </h2>
                </div>

                <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-blue-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- CUSTOMERS -->
        <div class="bg-white rounded-2xl shadow-sm border p-6 hover:shadow-lg transition duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Customers</p>
                    <h2 class="text-3xl font-bold text-gray-800 mt-1">
                        {{ $totalCustomers ?? 0 }}
                    </h2>
                </div>

                <div class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center">
                    <i class="fas fa-users text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- REVENUE -->
        <div class="bg-white rounded-2xl shadow-sm border p-6 hover:shadow-lg transition duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Revenue</p>
                    <h2 class="text-2xl font-bold text-emerald-600 mt-1">
                        Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}
                    </h2>
                </div>

                <div class="w-14 h-14 rounded-2xl bg-emerald-100 flex items-center justify-center">
                    <i class="fas fa-wallet text-emerald-600 text-2xl"></i>
                </div>
            </div>
        </div>

    </div>

    <!-- ORDER STATUS -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

        <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-5">
            <p class="text-sm text-yellow-600">Pending Orders</p>
            <h2 class="text-3xl font-bold text-yellow-700 mt-2">
                {{ $pendingOrders ?? 0 }}
            </h2>
        </div>

        <div class="bg-blue-50 border border-blue-200 rounded-2xl p-5">
            <p class="text-sm text-blue-600">Processed Orders</p>
            <h2 class="text-3xl font-bold text-blue-700 mt-2">
                {{ $processedOrders ?? 0 }}
            </h2>
        </div>

        <div class="bg-purple-50 border border-purple-200 rounded-2xl p-5">
            <p class="text-sm text-purple-600">Shipped Orders</p>
            <h2 class="text-3xl font-bold text-purple-700 mt-2">
                {{ $shippedOrders ?? 0 }}
            </h2>
        </div>

        <div class="bg-green-50 border border-green-200 rounded-2xl p-5">
            <p class="text-sm text-green-600">Completed Orders</p>
            <h2 class="text-3xl font-bold text-green-700 mt-2">
                {{ $completedOrders ?? 0 }}
            </h2>
        </div>

    </div>

    <!-- PAYMENT STATUS -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">

    <!-- PENDING PAYMENT -->
    <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-5">
        <p class="text-sm text-yellow-600">
            Pending Payments
        </p>

        <h2 class="text-3xl font-bold text-yellow-700 mt-2">
            {{ $pendingPayments ?? 0 }}
        </h2>
    </div>

    <!-- PAID PAYMENT -->
    <div class="bg-green-50 border border-green-200 rounded-2xl p-5">
        <p class="text-sm text-green-600">
            Paid Payments
        </p>

        <h2 class="text-3xl font-bold text-green-700 mt-2">
            {{ $paidPayments ?? 0 }}
        </h2>
    </div>

    <!-- REJECTED PAYMENT -->
    <div class="bg-red-50 border border-red-200 rounded-2xl p-5">
        <p class="text-sm text-red-600">
            Rejected Payments
        </p>

        <h2 class="text-3xl font-bold text-red-700 mt-2">
            {{ $rejectedPayments ?? 0 }}
        </h2>
    </div>

</div>

    <!-- BOTTOM GRID -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        <!-- RECENT ORDERS -->
        <div class="xl:col-span-2 bg-white rounded-2xl shadow-sm border overflow-hidden">

            <div class="p-6 border-b">
                <h2 class="text-lg font-semibold text-gray-800">
                    Recent Orders
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="text-left px-6 py-4 text-gray-500">Order ID</th>
                            <th class="text-left px-6 py-4 text-gray-500">Status</th>
                            <th class="text-left px-6 py-4 text-gray-500">Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($recentOrders as $order)
                            <tr class="border-t hover:bg-gray-50 transition">

                                <td class="px-6 py-4 font-medium text-gray-700">
                                    #{{ $order->id }}
                                </td>

                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                                        @if($order->status == 'pending')
                                            bg-yellow-100 text-yellow-700
                                        @elseif($order->status == 'processed')
                                            bg-blue-100 text-blue-700
                                        @elseif($order->status == 'shipped')
                                            bg-purple-100 text-purple-700
                                        @else
                                            bg-green-100 text-green-700
                                        @endif
                                    ">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 font-semibold text-gray-800">
                                    Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-10 text-gray-400">
                                    Belum ada order terbaru
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- LOW STOCK -->
        <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">

            <div class="p-6 border-b">
                <h2 class="text-lg font-semibold text-gray-800">
                    Low Stock Products
                </h2>
            </div>

            <div class="p-6 space-y-4">

                @forelse($lowStockProducts as $product)

                    <div class="flex items-center justify-between">

                        <div>
                            <p class="font-medium text-gray-700">
                                {{ $product->name }}
                            </p>

                            <p class="text-sm text-gray-400">
                                Product Stock
                            </p>
                        </div>

                        <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-sm font-semibold">
                            {{ $product->stock }}
                        </span>

                    </div>

                @empty

                    <div class="text-center py-8 text-gray-400">
                        Semua stock aman
                    </div>

                @endforelse

            </div>
        </div>

    </div>

</div>
@endsection