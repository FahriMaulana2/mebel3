<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // ================= TOTAL DATA =================
        $totalProducts = Product::count();

        $totalOrders = Order::count();

        $totalCustomers = User::where('is_admin', false)->count();

        $totalRevenue = Order::where('status', 'completed')
            ->sum('grand_total');

        // ================= ORDER STATUS =================
        $pendingOrders = Order::where('status', 'pending')->count();

        $processedOrders = Order::where('status', 'processed')->count();

        $shippedOrders = Order::where('status', 'shipped')->count();

        $completedOrders = Order::where('status', 'completed')->count();

        // ================= PAYMENT STATUS =================
        $pendingPayments = Order::where('payment_status', 'pending')
            ->count();

        $paidPayments = Order::where('payment_status', 'paid')
            ->count();

        $rejectedPayments = Order::where('payment_status', 'rejected')
            ->count();

        // ================= RECENT DATA =================
        $recentOrders = Order::latest()
            ->take(5)
            ->get();

        $lowStockProducts = Product::where('stock', '<', 5)
            ->where('stock', '>', 0)
            ->take(5)
            ->get();

        $outOfStockProducts = Product::where('stock', 0)
            ->take(5)
            ->get();

        // ================= MONTHLY REVENUE =================
        $monthlyRevenue = Order::where('status', 'completed')
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('grand_total');

        // ================= DEBUG LOG =================
        \Log::info('=== DASHBOARD DATA ===');

        \Log::info('Total Products: ' . $totalProducts);

        \Log::info('Total Orders: ' . $totalOrders);

        \Log::info('Pending Payments: ' . $pendingPayments);

        \Log::info('Paid Payments: ' . $paidPayments);

        \Log::info('Rejected Payments: ' . $rejectedPayments);

        \Log::info('======================');

        // ================= RETURN VIEW =================
        return view('admin.dashboard', compact(
            'totalProducts',
            'totalOrders',
            'totalCustomers',
            'totalRevenue',

            'pendingOrders',
            'processedOrders',
            'shippedOrders',
            'completedOrders',

            'pendingPayments',
            'paidPayments',
            'rejectedPayments',

            'recentOrders',
            'lowStockProducts',
            'outOfStockProducts',

            'monthlyRevenue'
        ));
    }
}