<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Shipment;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('frontend.checkout.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fullname'     => 'required|string|max:255',
            'phone'        => 'required|string|max:20',
            'address'      => 'required|string',
            'city'         => 'required|string|max:100',
            'postal_code'  => 'required|string|max:10',
            'courier'      => 'required|string',
            'cart_data'    => 'required',
        ]);

        $cart = json_decode($request->cart_data, true);

        if (!$cart || count($cart) == 0) {
            return back()->with('error', 'Cart kosong!');
        }

        /*
        |--------------------------------------------------------------------------
        | HITUNG SUBTOTAL
        |--------------------------------------------------------------------------
        */
        $subtotal = 0;

        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        /*
        |--------------------------------------------------------------------------
        | SHIPPING
        |--------------------------------------------------------------------------
        */
        $shippingCost = 20000;

        /*
        |--------------------------------------------------------------------------
        | VOUCHER
        |--------------------------------------------------------------------------
        */
        $discount = 0;
        $voucherId = null;

        if ($request->voucher_code) {


            $voucher = Voucher::where('code', strtoupper($request->voucher_code))
                ->where('is_active', true)
                ->first();

            if (!$voucher) {
                return back()->with('error', 'Voucher tidak valid');
            }

            // STRICT RULE: 1 user can use the same voucher only once
            if (auth()->id()) {
                $alreadyUsed = Order::where('user_id', auth()->id())
                    ->where('voucher_id', $voucher->id)
                    ->exists();

                if ($alreadyUsed) {
                    return back()->with('error', 'Voucher sudah pernah digunakan');
                }
            }


            $voucherId = $voucher->id;

            // cek expired

            if ($voucher->expired_at && now()->gt($voucher->expired_at)) {
                return back()->with('error', 'Voucher sudah expired');
            }

            // cek minimum order
            if ($subtotal < $voucher->minimum_order) {
                return back()->with(
                    'error',
                    'Minimum order Rp ' .
                    number_format($voucher->minimum_order, 0, ',', '.')
                );
            }

            // hitung diskon
            if ($voucher->type === 'percent') {

                $discount = $subtotal * ($voucher->value / 100);

            } else {

                $discount = $voucher->value;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | GRAND TOTAL
        |--------------------------------------------------------------------------
        */
        $grandTotal = ($subtotal + $shippingCost) - $discount;

        if ($grandTotal < 0) {
            $grandTotal = 0;
        }

        /*
        |--------------------------------------------------------------------------
        | ORDER NUMBER
        |--------------------------------------------------------------------------
        */
        $orderNumber = 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(6));

        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | CREATE ORDER
            |--------------------------------------------------------------------------
            */
            $order = Order::create([
                'order_number'   => $orderNumber,
                'user_id'        => auth()->id(),

                'fullname'       => $request->fullname,
                'phone'          => $request->phone,
                'address'        => $request->address,
                'city'           => $request->city,
                'postal_code'    => $request->postal_code,
                'courier'        => $request->courier,

                'items'          => json_encode($cart),

                'total_amount'   => $subtotal,
                'shipping_cost'  => $shippingCost,
                'grand_total'    => $grandTotal,

'status'         => 'pending',
                'payment_status' => 'pending',

                'notes'          => 'Order via WhatsApp',
                'voucher_id'    => $voucherId,
            ]);


            /*
            |--------------------------------------------------------------------------
            | ORDER ITEMS
            |--------------------------------------------------------------------------
            */
            foreach ($cart as $item) {

                OrderItem::create([
                    'order_id'      => $order->id,
                    'product_id'    => $item['id'],
                    'product_name'  => $item['name'],
                    'product_price' => $item['price'],
                    'quantity'      => $item['quantity'],
                    'subtotal'      => $item['price'] * $item['quantity'],
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | PAYMENT
            |--------------------------------------------------------------------------
            */
            Payment::create([
                'order_id'       => $order->id,
                'amount'         => $grandTotal,
                'payment_method' => 'whatsapp',

                // GANTI unpaid -> pending
                'status'         => 'pending',
            ]);

            /*
            |--------------------------------------------------------------------------
            | SHIPMENT
            |--------------------------------------------------------------------------
            */
            Shipment::create([
                'order_id'       => $order->id,
                'recipient_name' => $request->fullname,
                'phone'          => $request->phone,
                'address'        => $request->address,
                'city'           => $request->city,
                'postal_code'    => $request->postal_code,
                'courier'        => $request->courier,
                'status'         => 'pending',
            ]);

        DB::commit();

            // Pastikan nomor tujuan checkout tersimpan (orders.phone + shipments.phone)
            // Lalu redirect ke halaman success yang berisi redirect manual ke WhatsApp admin.
            // Redirect WhatsApp tetap berbasis wa.me seperti sistem existing Anda.
            // Data order dan shipment sudah disimpan terlebih dahulu di database.
            return redirect()->route('checkout.success', $orderNumber);

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }

    public function success($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | NOMOR ADMIN
        |--------------------------------------------------------------------------
        */
        $adminPhone = '6283831520933';

        /*
        |--------------------------------------------------------------------------
        | DECODE ITEMS
        |--------------------------------------------------------------------------
        */
        $items = json_decode($order->items, true);

        /*
        |--------------------------------------------------------------------------
        | HITUNG DISKON
        |--------------------------------------------------------------------------
        */
        $discount = ($order->total_amount + $order->shipping_cost)
            - $order->grand_total;

        /*
        |--------------------------------------------------------------------------
        | BUAT PESAN WHATSAPP
        |--------------------------------------------------------------------------
        */
        $message = "*🛍️ ORDER BARU DARI KIANA FURNITURE*%0A%0A";

        $message .= "*📋 DETAIL PEMESAN:*%0A";
        $message .= "Nama: {$order->fullname}%0A";
        $message .= "No. HP: {$order->phone}%0A";
        $message .= "Alamat: {$order->address}%0A";
        $message .= "Kota: {$order->city}%0A";
        $message .= "Kode Pos: {$order->postal_code}%0A";
        $message .= "Kurir: {$order->courier}%0A%0A";

        $message .= "*🛒 PRODUK YANG DIPESAN:*%0A";

        foreach ($items as $index => $item) {

            $subtotal = $item['price'] * $item['quantity'];

            $message .= ($index + 1) . ". ";
            $message .= "{$item['name']} ";
            $message .= "- {$item['quantity']} x Rp ";
            $message .= number_format($item['price'], 0, ',', '.');
            $message .= " = Rp ";
            $message .= number_format($subtotal, 0, ',', '.');
            $message .= "%0A";
        }

        /*
        |--------------------------------------------------------------------------
        | TOTAL PEMBAYARAN
        |--------------------------------------------------------------------------
        */
        $message .= "%0A*💰 TOTAL PEMBAYARAN:*%0A";

        $message .= "Subtotal: Rp "
            . number_format($order->total_amount, 0, ',', '.')
            . "%0A";

        $message .= "Ongkir: Rp "
            . number_format($order->shipping_cost, 0, ',', '.')
            . "%0A";

        if ($discount > 0) {

            $message .= "Diskon Voucher: -Rp "
                . number_format($discount, 0, ',', '.')
                . "%0A";
        }

        $message .= "Grand Total: Rp "
            . number_format($order->grand_total, 0, ',', '.')
            . "%0A%0A";

        $message .= "_Pesan dikirim dari website Kiana Furniture_";

        /*
        |--------------------------------------------------------------------------
        | URL WHATSAPP
        |--------------------------------------------------------------------------
        */
        $whatsappUrl = "https://wa.me/{$adminPhone}?text={$message}";

        return view('frontend.checkout.success', compact(
            'order',
            'whatsappUrl'
        ));
    }
}