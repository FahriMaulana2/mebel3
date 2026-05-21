<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'payment', 'shipment'])
            ->latest()
            ->paginate(15);

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

        // update status order
        $order->status = $newStatus;
        $order->save();

        // update shipment status
        if ($newStatus === 'shipped' && $order->shipment) {
            $order->shipment->status = 'shipped';
            $order->shipment->save();
        }

        // update payment status
        if ($newStatus === 'completed' && $order->payment) {
            $order->payment->status = 'paid';
            $order->payment->save();
        }

        /**
         * ============================
         * WHATSAPP NOTIFICATION (FONNTE)
         * ============================
         */
        if ($oldStatus !== $newStatus) {

            $order->loadMissing(['shipment', 'user']);

            /**
             * 🔥 FIX UTAMA:
             * fallback ke orders.phone kalau shipment null
             */
            $rawPhone =
                $order->shipment?->phone
                ?? $order->phone
                ?? null;

            $wa = app(\App\Services\WhatsAppService::class);

            if ($rawPhone && $wa->isValidIndonesiaPhone($rawPhone)) {

                $target = $wa->normalizeToCountryCode62($rawPhone);

                $invoiceNumber = (string) ($order->invoice_number ?? $order->order_number);

                $customerName = (string) (
                    $order->shipment?->recipient_name
                    ?? $order->fullname
                    ?? $order->user?->name
                );

                $message = $wa->messageForStatus([
                    'customer_name' => $customerName,
                    'invoice_number' => $invoiceNumber,
                ], $newStatus);

                try {
                    $response = $wa->send($target, $message);

                    // optional debug kalau mau cek
                    // \Log::info('Fonnte response', $response);

                } catch (\Throwable $e) {

                    // jangan ganggu sistem admin
                    \Log::error('WhatsApp Fonnte error: ' . $e->getMessage());
                }
            }
        }

        return redirect()
            ->back()
            ->with('success', 'Order status updated successfully!');
    }
}