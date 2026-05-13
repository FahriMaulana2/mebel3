<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('order')->latest()->paginate(15);
        return view('admin.payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        $payment->load('order');
        return view('admin.payments.show', compact('payment'));
    }

    public function verify(Payment $payment)
    {
        $payment->status = 'paid';
        $payment->paid_at = now();
        $payment->save();

        // Also update order status
        if ($payment->order && $payment->order->status == 'pending') {
            $payment->order->status = 'processed';
            $payment->order->save();
        }

        return redirect()->back()->with('success', 'Payment verified successfully!');
    }

    public function reject(Payment $payment)
    {
        $payment->status = 'failed';
        $payment->save();

        return redirect()->back()->with('warning', 'Payment rejected!');
    }
}