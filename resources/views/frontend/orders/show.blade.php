@extends('layouts.app')

@section('title', 'Order Details - Kiana Furniture')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-8">Order #{{ $order->id }}</h1>
        
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Order Items -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Items</h2>
                    
                    @foreach($order->orderItems as $item)
                        <div class="flex justify-between py-3 border-b">
                            <div class="flex items-center">
                                @if($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="h-16 w-16 object-cover rounded">
                                @else
                                    <div class="h-16 w-16 bg-gray-200 rounded flex items-center justify-center">
                                        <span class="text-gray-400 text-xs">No Image</span>
                                    </div>
                                @endif
                                <div class="ml-4">
                                    <p class="font-medium text-gray-900">{{ $item->product->name }}</p>
                                    <p class="text-sm text-gray-500">Qty: {{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <p class="font-medium text-gray-900">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                        </div>
                    @endforeach
                    
                    <div class="flex justify-between py-4">
                        <p class="font-semibold text-gray-900">Total</p>
                        <p class="text-xl font-bold text-[#8B5E3C]">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                    </div>
                </div>
                
                <!-- Shipment Info -->
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Shipping Information</h2>
                    <p class="text-gray-600 mb-2">{{ $order->shipment->shipping_address }}</p>
                    <p class="text-gray-600">Courier: {{ $order->shipment->courier }}</p>
                    @if($order->shipment->tracking_number)
                        <p class="text-gray-600">Tracking: {{ $order->shipment->tracking_number }}</p>
                    @endif
                    <p class="mt-2">
                        Status: 
                        <span class="px-2 py-1 text-xs rounded 
                            @if($order->shipment->status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($order->shipment->status == 'shipped') bg-purple-100 text-purple-800
                            @else bg-green-100 text-green-800 @endif">
                            {{ ucfirst($order->shipment->status) }}
                        </span>
                    </p>
                </div>
                
                <!-- Payment Info -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Payment Information</h2>
                    <p class="text-gray-600">Amount: Rp {{ number_format($order->payment->amount, 0, ',', '.') }}</p>
                    <p class="text-gray-600">Method: {{ ucfirst(str_replace('_', ' ', $order->payment->payment_method)) }}</p>
                    <p class="mb-4">
                        Status: 
                        <span class="px-2 py-1 text-xs rounded 
                            @if($order->payment->status == 'unpaid') bg-red-100 text-red-800
                            @elseif($order->payment->status == 'waiting_verification') bg-yellow-100 text-yellow-800
                            @else bg-green-100 text-green-800 @endif">
                            {{ ucfirst(str_replace('_', ' ', $order->payment->status)) }}
                        </span>
                    </p>
                    
                    @if($order->payment->status == 'unpaid' && !$order->payment->payment_proof)
                        <form method="POST" action="{{ route('orders.uploadPayment', $order->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2">Upload Payment Proof</label>
                                <input type="file" name="payment_proof" class="w-full border rounded px-4 py-2" required>
                            </div>
                            <button type="submit" class="bg-[#8B5E3C] text-white px-6 py-2 rounded hover:bg-[#7A4F34]">Upload</button>
                        </form>
                    @elseif($order->payment->payment_proof)
                        <p class="text-gray-600">Payment proof uploaded</p>
                    @endif
                </div>
            </div>
            
            <!-- Order Status -->
            <div>
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Status</h2>
                    <p class="text-gray-600 mb-4">Date: {{ $order->created_at->format('d M Y H:i') }}</p>
                    <p class="mb-4">
                        Status: 
                        <span class="px-2 py-1 text-xs rounded 
                            @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($order->status == 'processed') bg-blue-100 text-blue-800
                            @elseif($order->status == 'shipped') bg-purple-100 text-purple-800
                            @else bg-green-100 text-green-800 @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>
                    
                    <a href="{{ route('orders.index') }}" class="text-[#8B5E3C] hover:underline">← Back to Orders</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
