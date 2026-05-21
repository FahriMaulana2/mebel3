<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderStatusUpdatedMail;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
        $order->load(['orderItems.product', 'payment', 'shipment']);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processed,shipped,completed,cancelled',
        ]);

        $oldStatus = (string) $order->status;
        $newStatus = (string) $request->status;

        // Jangan kirim email kalau status sama
        if ($oldStatus === $newStatus) {

            return redirect()
                ->back()
                ->with('info', 'Status tidak berubah.');
        }

        /**
         * ============================
         * UPDATE ORDER STATUS
         * ============================
         */
        $order->status = $newStatus;
        $order->save();

        /**
         * ============================
         * UPDATE SHIPMENT STATUS
         * ============================
         */
        if ($newStatus === 'shipped' && $order->shipment) {

            $order->shipment->status = 'shipped';
            $order->shipment->save();
        }

        /**
         * ============================
         * UPDATE PAYMENT STATUS
         * ============================
         */
        if ($newStatus === 'completed' && $order->payment) {

            $order->payment->status = 'paid';
            $order->payment->save();
        }

        /**
         * ============================
         * WHATSAPP NOTIFICATION
         * ============================
         */
        try {

            $order->loadMissing(['shipment', 'user']);

            $rawPhone =
                $order->shipment?->phone
                ?? $order->phone
                ?? null;

            $wa = app(\App\Services\WhatsAppService::class);

            if ($rawPhone && $wa->isValidIndonesiaPhone($rawPhone)) {

                $target = $wa->normalizeToCountryCode62($rawPhone);

                $invoiceNumber = (string) (
                    $order->invoice_number
                    ?? $order->order_number
                );

                $customerName = (string) (
                    $order->shipment?->recipient_name
                    ?? $order->fullname
                    ?? $order->user?->name
                    ?? 'Customer'
                );

                $message = $wa->messageForStatus([
                    'customer_name' => $customerName,
                    'invoice_number' => $invoiceNumber,
                ], $newStatus);

                $wa->send($target, $message);
            }

        } catch (\Throwable $e) {

            \Log::error('WhatsApp Fonnte error: ' . $e->getMessage());
        }

        /**
         * ============================
         * EMAIL NOTIFICATION
         * ============================
         */
        try {

            // DEBUG
            \Log::info('EMAIL DEBUG', [
                'email' => $order->email,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
            ]);

            if (!empty($order->email)) {

                Mail::to($order->email)->send(
                    new OrderStatusUpdatedMail($order, $newStatus)
                );

                \Log::info('EMAIL BERHASIL DIKIRIM KE: ' . $order->email);
            }

        } catch (\Throwable $e) {

            \Log::error('Order status email error: ' . $e->getMessage());
        }

        return redirect()
            ->back()
            ->with('success', 'Order status updated successfully!');
    }
}