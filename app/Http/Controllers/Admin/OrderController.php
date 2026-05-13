<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'payment', 'shipment'])->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['items.product', 'payment', 'shipment']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processed,shipped,completed,cancelled',
        ]);

        $order->status = $request->status;
        $order->save();

        // If status is shipped, update shipment status
        if ($request->status == 'shipped' && $order->shipment) {
            $order->shipment->markAsShipped();
        }

        // If status is completed, update payment status
        if ($request->status == 'completed' && $order->payment) {
            $order->payment->markAsPaid();
        }

        return redirect()->back()->with('success', 'Order status updated successfully!');
    }
}