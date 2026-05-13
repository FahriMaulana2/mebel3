@extends('admin.layouts.admin')

@section('title', 'Order Details')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.orders.index') }}" class="text-brown-600 hover:underline">
            &larr; Back to Orders
        </a>
    </div>
    
    <div class="flex justify-between items-start mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Order #{{ $order->order_number }}</h1>
        <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
            @csrf
            @method('PUT')
            <select name="status" class="border rounded-lg px-3 py-2" onchange="this.form.submit()">
                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processed" {{ $order->status == 'processed' ? 'selected' : '' }}>Processed</option>
                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </form>
    </div>
    
    <div class="grid md:grid-cols-2 gap-6">
        <!-- Customer Information -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-lg font-semibold mb-4">Customer Information</h2>
            <p><strong>Name:</strong> {{ $order->shipment->recipient_name ?? 'N/A' }}</p>
            <p><strong>Phone:</strong> {{ $order->shipment->phone ?? 'N/A' }}</p>
            <p><strong>Address:</strong> {{ $order->shipment->address ?? 'N/A' }}</p>
            <p><strong>City:</strong> {{ $order->shipment->city ?? 'N/A' }}</p>
            <p><strong>Postal Code:</strong> {{ $order->shipment->postal_code ?? 'N/A' }}</p>
            <p><strong>Courier:</strong> {{ strtoupper($order->shipment->courier ?? 'N/A') }}</p>
        </div>
        
        <!-- Payment Information -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-lg font-semibold mb-4">Payment Information</h2>
            <p><strong>Amount:</strong> Rp {{ number_format($order->grand_total, 0, ',', '.') }}</p>
            <p><strong>Status:</strong> 
                <span class="px-2 py-1 text-xs rounded-full 
                    @if($order->payment?->status == 'paid') bg-green-100 text-green-700
                    @elseif($order->payment?->status == 'waiting_verification') bg-yellow-100 text-yellow-700
                    @else bg-red-100 text-red-700 @endif">
                    {{ $order->payment?->status ?? 'unpaid' }}
                </span>
            </p>
        </div>
    </div>
    
    <!-- Order Items -->
    <div class="bg-white rounded-xl shadow-md p-6 mt-6">
        <h2 class="text-lg font-semibold mb-4">Order Items</h2>
        
        @php
            // Decode items jika disimpan sebagai JSON string
            $items = $order->items;
            if (is_string($items)) {
                $items = json_decode($items, true);
            }
        @endphp
        
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left">Product</th>
                    <th class="px-4 py-3 text-center">Price</th>
                    <th class="px-4 py-3 text-center">Quantity</th>
                    <th class="px-4 py-3 text-center">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                <tr class="border-b">
                    <td class="px-4 py-3">{{ $item['name'] ?? $item['product_name'] ?? 'N/A' }}</td>
                    <td class="px-4 py-3 text-center">Rp {{ number_format($item['price'] ?? $item['product_price'] ?? 0, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 text-center">{{ $item['quantity'] ?? 0 }}</td>
                    <td class="px-4 py-3 text-center">Rp {{ number_format(($item['price'] ?? $item['product_price'] ?? 0) * ($item['quantity'] ?? 0), 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-8 text-center text-gray-500">No items found</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot class="bg-gray-50">
                <tr>
                    <td colspan="3" class="px-4 py-3 text-right font-bold">Subtotal:</td>
                    <td class="px-4 py-3 text-center">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="px-4 py-3 text-right font-bold">Shipping:</td>
                    <td class="px-4 py-3 text-center">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="px-4 py-3 text-right font-bold text-lg">Grand Total:</td>
                    <td class="px-4 py-3 text-center font-bold text-brown-600">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
    
    <!-- Shipment Information -->
    <div class="bg-white rounded-xl shadow-md p-6 mt-6">
        <h2 class="text-lg font-semibold mb-4">Shipment Information</h2>
        <p><strong>Courier:</strong> {{ strtoupper($order->shipment->courier ?? 'N/A') }}</p>
        <p><strong>Tracking Number:</strong> {{ $order->shipment->tracking_number ?? 'Not set' }}</p>
        <p><strong>Status:</strong> {{ ucfirst($order->shipment->status ?? 'pending') }}</p>
        
        @if($order->shipment && !$order->shipment->tracking_number)
        <form action="{{ route('admin.shipments.update-tracking', $order->shipment) }}" method="POST" class="mt-4">
            @csrf
            @method('PUT')
            <div class="flex gap-2">
                <input type="text" name="tracking_number" placeholder="Enter tracking number" class="flex-1 border rounded-lg px-4 py-2">
                <button type="submit" class="bg-brown-600 text-white px-4 py-2 rounded-lg">Update</button>
            </div>
        </form>
        @endif
    </div>
</div>
@endsection