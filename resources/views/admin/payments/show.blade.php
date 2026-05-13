@extends('admin.layouts.admin')

@section('title', 'Payment Details')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6"><a href="{{ route('admin.payments.index') }}" class="text-brown-600 hover:underline">&larr; Back to Payments</a></div>
    <div class="bg-white rounded-xl shadow-md p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Payment Details</h1>
        <p><strong>Order Number:</strong> {{ $payment->order->order_number }}</p>
        <p><strong>Amount:</strong> Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
        <p><strong>Bank:</strong> {{ strtoupper($payment->bank_name) }}</p>
        <p><strong>Account Name:</strong> {{ $payment->account_name }}</p>
        <p><strong>Status:</strong> <span class="px-2 py-1 text-xs rounded-full @if($payment->status == 'paid') bg-green-100 text-green-700 @elseif($payment->status == 'waiting_verification') bg-yellow-100 text-yellow-700 @else bg-red-100 text-red-700 @endif">{{ $payment->status }}</span></p>
        @if($payment->proof_image)<div class="my-6"><p class="font-medium mb-2">Payment Proof:</p><img src="{{ asset('storage/'.$payment->proof_image) }}" class="max-w-full rounded-lg border"></div>@endif
        <div class="flex gap-3 mt-6">
            @if($payment->status == 'waiting_verification')
            <form action="{{ route('admin.payments.verify', $payment) }}" method="POST">@csrf<button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">Verify Payment</button></form>
            <form action="{{ route('admin.payments.reject', $payment) }}" method="POST">@csrf<button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700">Reject Payment</button></form>
            @endif
            <a href="{{ route('admin.orders.show', $payment->order) }}" class="bg-brown-600 text-white px-6 py-2 rounded-lg hover:bg-brown-700">View Order</a>
        </div>
    </div>
</div>
@endsection