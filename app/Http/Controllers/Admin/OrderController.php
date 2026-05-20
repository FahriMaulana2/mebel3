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

        $oldStatus = (string) $order->status;
        $newStatus = (string) $request->status;

        $order->status = $newStatus;
        $order->save();

        // If status is shipped, update shipment status
        if ($newStatus === 'shipped' && $order->shipment) {
            $order->shipment->markAsShipped();
        }

        // If status is completed, update payment status
        if ($newStatus === 'completed' && $order->payment) {
            $order->payment->markAsPaid();
        }

        // WhatsApp notification only when status actually changes
        if ($oldStatus !== $newStatus) {
            $order->loadMissing(['shipment']);

            $rawPhone = $order->shipment?->phone; // phone taken from checkout -> shipment.phone

            $wa = app(\App\Services\WhatsAppService::class);

            if ($wa->isValidIndonesiaPhone($rawPhone)) {
                $target = $wa->normalizeToCountryCode62($rawPhone);

                $invoiceNumber = (string) ($order->invoice_number ?? $order->order_number);
                $customerName = (string) ($order->shipment?->recipient_name ?? $order->fullname ?? $order->user?->name);

                $message = $wa->messageForStatus([
                    'customer_name' => $customerName,
                    'invoice_number' => $invoiceNumber,
                ], $newStatus);

                try {
                    $wa->send($target, $message);
                } catch (\Throwable $e) {
                    // Jangan ganggu proses admin/order jika WhatsApp gagal.
                    // Anda bisa tambahkan logging bila dibutuhkan.
                }
            }
        }

        return redirect()->back()->with('success', 'Order status updated successfully!');
    }
}