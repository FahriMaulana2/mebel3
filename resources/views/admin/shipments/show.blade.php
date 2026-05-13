@extends('admin.layouts.admin')

@section('title', 'Shipment Details')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6"><a href="{{ route('admin.shipments.index') }}" class="text-brown-600 hover:underline">&larr; Back to Shipments</a></div>
    <div class="bg-white rounded-xl shadow-md p-6"><h1 class="text-2xl font-bold text-gray-800 mb-6">Shipment Details</h1>
        <p><strong>Order Number:</strong> {{ $shipment->order->order_number }}</p>
        <p><strong>Recipient:</strong> {{ $shipment->recipient_name }}</p>
        <p><strong>Phone:</strong> {{ $shipment->phone }}</p>
        <p><strong>Address:</strong> {{ $shipment->address }}, {{ $shipment->city }} {{ $shipment->postal_code }}</p>
        <p><strong>Courier:</strong> {{ strtoupper($shipment->courier) }}</p>
        <p><strong>Tracking Number:</strong> {{ $shipment->tracking_number ?? 'Not set' }}</p>
        <p><strong>Status:</strong> <span class="px-2 py-1 text-xs rounded-full @if($shipment->status == 'delivered') bg-green-100 text-green-700 @elseif($shipment->status == 'shipped') bg-purple-100 text-purple-700 @else bg-yellow-100 text-yellow-700 @endif">{{ ucfirst($shipment->status) }}</span></p>
        @if(!$shipment->tracking_number)<form action="{{ route('admin.shipments.update-tracking', $shipment) }}" method="POST" class="mt-6">@csrf @method('PUT')
            <div class="flex gap-2"><input type="text" name="tracking_number" placeholder="Enter tracking number" class="flex-1 border rounded-lg px-4 py-2"><button type="submit" class="bg-brown-600 text-white px-6 py-2 rounded-lg">Update Tracking</button></div>
        </form>@endif
        <div class="flex gap-3 mt-6"><a href="{{ route('admin.orders.show', $shipment->order) }}" class="bg-brown-600 text-white px-6 py-2 rounded-lg hover:bg-brown-700">View Order</a></div>
    </div>
</div>
@endsection