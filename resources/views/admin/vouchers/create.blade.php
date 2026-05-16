@extends('admin.layouts.app')

@section('title', 'Create Voucher')

@section('content')

<div class="max-w-4xl mx-auto">

    <!-- HEADER -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Create Voucher
            </h1>

            <p class="text-gray-500 mt-1">
                Tambahkan voucher diskon baru
            </p>
        </div>

        <a href="{{ route('admin.vouchers.index') }}"
           class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-3 rounded-xl transition">
            Back
        </a>
    </div>

    <!-- ERROR -->
    @if ($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-700 px-5 py-4 rounded-2xl mb-6">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- CARD -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">

        <form action="{{ route('admin.vouchers.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- CODE -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Voucher Code
                    </label>

                    <input
                        type="text"
                        name="code"
                        value="{{ old('code') }}"
                        placeholder="Contoh: KIANA30"
                        class="w-full border border-gray-200 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-amber-500"
                        required
                    >
                </div>

                <!-- TYPE -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Voucher Type
                    </label>

                    <select
                        name="type"
                        class="w-full border border-gray-200 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-amber-500"
                        required
                    >
                        <option value="">Select Type</option>

                        <option value="percent">
                            Percentage (%)
                        </option>

                        <option value="fixed">
                            Fixed Amount (Rp)
                        </option>
                    </select>
                </div>

                <!-- VALUE -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Discount Value
                    </label>

                    <input
                        type="number"
                        name="value"
                        value="{{ old('value') }}"
                        placeholder="30"
                        class="w-full border border-gray-200 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-amber-500"
                        required
                    >
                </div>

                <!-- MIN ORDER -->
<div>
    <label class="block text-sm font-semibold text-gray-700 mb-2">
        Minimum Order
    </label>

    <input
        type="number"
        name="minimum_order"
        value="{{ old('minimum_order') }}"
        placeholder="1000000"
        class="w-full border border-gray-200 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-amber-500"
    >
</div>

                <!-- EXPIRED -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Expired Date
                    </label>

                    <input
                        type="date"
                        name="expired_at"
                        value="{{ old('expired_at') }}"
                        class="w-full border border-gray-200 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-amber-500"
                    >
                </div>

            </div>

            <!-- ACTIVE -->
            <div class="mt-6 flex items-center gap-3">
                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    checked
                    class="w-5 h-5 rounded text-amber-600"
                >

                <label class="text-gray-700 font-medium">
                    Active Voucher
                </label>
            </div>

            <!-- BUTTON -->
            <div class="mt-8 flex justify-end gap-4">

                <a href="{{ route('admin.vouchers.index') }}"
                   class="px-6 py-3 rounded-2xl bg-gray-100 hover:bg-gray-200 transition">
                    Cancel
                </a>

                <button
                    type="submit"
                    class="px-8 py-3 rounded-2xl bg-amber-600 hover:bg-amber-700 text-white font-semibold transition"
                >
                    Save Voucher
                </button>

            </div>

        </form>

    </div>

</div>

@endsection