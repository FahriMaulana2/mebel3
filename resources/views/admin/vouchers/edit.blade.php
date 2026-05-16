@extends('admin.layouts.admin')

@section('title', 'Edit Voucher')

@section('content')

<div class="max-w-2xl mx-auto">

    <h1 class="text-2xl font-bold mb-6">
        Edit Voucher
    </h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.vouchers.update', $voucher->id) }}"
          method="POST"
          class="bg-white p-6 rounded shadow">

        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-1 font-medium">
                Voucher Code
            </label>

            <input type="text"
                   name="code"
                   value="{{ old('code', $voucher->code) }}"
                   class="w-full border px-3 py-2 rounded"
                   required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">
                Discount Amount
            </label>

            <input type="number"
                   name="discount_amount"
                   value="{{ old('discount_amount', $voucher->discount_amount) }}"
                   class="w-full border px-3 py-2 rounded"
                   required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">
                Minimum Order
            </label>

            <input type="number"
                   name="min_order"
                   value="{{ old('min_order', $voucher->min_order) }}"
                   class="w-full border px-3 py-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">
                Expired Date
            </label>

            <input type="date"
                   name="expired_at"
                   value="{{ old('expired_at', $voucher->expired_at) }}"
                   class="w-full border px-3 py-2 rounded">
        </div>

        <div class="mb-6">
            <label>
                <input type="checkbox"
                       name="is_active"
                       value="1"
                       {{ $voucher->is_active ? 'checked' : '' }}>

                Active Voucher
            </label>
        </div>

        <div class="flex gap-3">

            <button class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">
                Update Voucher
            </button>

            <a href="{{ route('admin.vouchers.index') }}"
               class="bg-gray-500 text-white px-5 py-2 rounded hover:bg-gray-600">
                Cancel
            </a>

        </div>

    </form>

</div>

@endsection