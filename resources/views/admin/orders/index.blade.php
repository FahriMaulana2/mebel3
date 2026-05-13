@extends('admin.layouts.admin')

@section('title', 'Orders Management')

@section('content')
<div>
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Orders</h1>
    
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr><th class="px-4 py-3 text-left">Order #</th><th class="px-4 py-3 text-left">Customer</th><th class="px-4 py-3 text-left">Total</th><th class="px-4 py-3 text-left">Status</th><th class="px-4 py-3 text-left">Payment</th><th class="px-4 py-3 text-left">Date</th><th class="px-4 py-3 text-left">Action</th></tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr class="border-b table-row">
                    <td class="px-4 py-3">{{ $order->order_number }}</td>
                    <td class="px-4 py-3">{{ $order->user->name ?? 'Guest' }}</td>
                    <td class="px-4 py-3">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                    <td class="px-4 py-3"><span class="px-2 py-1 text-xs rounded-full @if($order->status == 'pending') bg-yellow-100 text-yellow-700 @elseif($order->status == 'processed') bg-blue-100 text-blue-700 @elseif($order->status == 'shipped') bg-purple-100 text-purple-700 @else bg-green-100 text-green-700 @endif">{{ ucfirst($order->status) }}</span></td>
                    <td class="px-4 py-3"><span class="px-2 py-1 text-xs rounded-full @if($order->payment?->status == 'paid') bg-green-100 text-green-700 @elseif($order->payment?->status == 'waiting_verification') bg-yellow-100 text-yellow-700 @else bg-red-100 text-red-700 @endif">{{ $order->payment?->status ?? 'unpaid' }}</span></td>
                    <td class="px-4 py-3">{{ $order->created_at->format('d/m/Y') }}</td>
                    <td class="px-4 py-3"><a href="{{ route('admin.orders.show', $order) }}" class="text-brown-600 hover:text-brown-700"><i class="fas fa-eye"></i></a></td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-4 py-8 text-center text-gray-500">No orders found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $orders->links() }}</div>
</div>
@endsection