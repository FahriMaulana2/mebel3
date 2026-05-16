<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('order')
            ->latest()
            ->paginate(15);

        return view('admin.payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        $payment->load('order');

        return view('admin.payments.show', compact('payment'));
    }

    // ✅ KONFIRM PAYMENT
    public function verify(Payment $payment)
    {
        $payment->markAsPaid(); // pakai method dari model

        return back()->with('success', 'Payment berhasil dikonfirmasi');
    }

    // ❌ REJECT PAYMENT
    public function reject(Payment $payment)
    {
        $payment->markAsRejected(); // pakai method dari model

        return back()->with('warning', 'Payment ditolak');
    }
}