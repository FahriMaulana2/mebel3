@extends('admin.layouts.admin')

@section('title', 'Payments Management')

@section('content')
<div>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Payments</h1>
    </div>
    
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Order #</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Amount</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Bank</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-sm">{{ $payment->order->order_number }}</td>
                        <td class="px-4 py-3 text-sm">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-sm">{{ strtoupper($payment->bank_name) }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs rounded-full 
                                @if($payment->status == 'paid') bg-green-100 text-green-700
                                @elseif($payment->status == 'waiting_verification') bg-yellow-100 text-yellow-700
                                @else bg-red-100 text-red-700 @endif">
                                {{ str_replace('_', ' ', $payment->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <a href="{{ route('admin.payments.show', $payment) }}" class="text-brown-600 hover:text-brown-700">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                            <i class="fas fa-credit-card text-4xl mb-2 block"></i>
                            No payments found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    @if($payments->hasPages())
    <div class="mt-6">
        {{ $payments->links() }}
    </div>
    @endif
</div>
@endsection