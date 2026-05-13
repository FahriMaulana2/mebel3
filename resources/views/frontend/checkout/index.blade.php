@extends('layouts.app')

@section('title', 'Checkout - Kiana Furniture')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-16">

    <h1 class="text-3xl font-playfair font-bold text-gray-800 mb-8">
        Checkout
    </h1>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
        @csrf

        <input type="hidden" name="cart_data" id="cart_data">

        <div class="grid md:grid-cols-2 gap-8">

            <!-- SHIPPING -->
            <div class="bg-white rounded-xl shadow-md p-6">

                <h2 class="text-xl font-semibold mb-4">
                    Shipping Information
                </h2>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">
                        Full Name *
                    </label>

                    <input
                        type="text"
                        name="fullname"
                        required
                        class="w-full border rounded-lg px-4 py-2"
                    >
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">
                        Phone Number *
                    </label>

                    <input
                        type="text"
                        name="phone"
                        required
                        class="w-full border rounded-lg px-4 py-2"
                    >
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">
                        Address *
                    </label>

                    <textarea
                        name="address"
                        rows="4"
                        required
                        class="w-full border rounded-lg px-4 py-2"
                    ></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">

                    <div>
                        <label class="block text-sm font-medium mb-1">
                            City *
                        </label>

                        <input
                            type="text"
                            name="city"
                            required
                            class="w-full border rounded-lg px-4 py-2"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Postal Code *
                        </label>

                        <input
                            type="text"
                            name="postal_code"
                            required
                            class="w-full border rounded-lg px-4 py-2"
                        >
                    </div>

                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">
                        Courier *
                    </label>

                    <select
                        name="courier"
                        class="w-full border rounded-lg px-4 py-2"
                    >
                        <option value="JNE">JNE</option>
                        <option value="J&T">J&T Express</option>
                        <option value="SiCepat">SiCepat</option>
                    </select>
                </div>

            </div>

            <!-- ORDER SUMMARY -->
            <div>

                <div class="bg-white rounded-xl shadow-md p-6 mb-6">

                    <h2 class="text-xl font-semibold mb-4">
                        Order Summary
                    </h2>

                    <div id="order-summary"></div>

                </div>

                <!-- BUTTON -->
                <div class="bg-green-50 rounded-xl shadow-md p-6 border border-green-200">

                    <div class="text-center mb-4">
                        <i class="fab fa-whatsapp text-5xl text-green-500 mb-2"></i>

                        <h2 class="text-xl font-semibold text-gray-800">
                            Checkout via WhatsApp
                        </h2>

                        <p class="text-gray-500 text-sm mt-1">
                            Order akan disimpan ke dashboard admin
                        </p>
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-green-500 text-white py-3 rounded-lg hover:bg-green-600 transition flex items-center justify-center gap-2"
                    >
                        <i class="fab fa-whatsapp text-xl"></i>
                        Checkout Sekarang
                    </button>

                </div>

            </div>

        </div>

    </form>

</div>

<script>

function loadOrderSummary() {

    const cart = JSON.parse(localStorage.getItem('kiana_cart') || '[]');

    const container = document.getElementById('order-summary');

    document.getElementById('cart_data').value = JSON.stringify(cart);

    if (cart.length === 0) {

        container.innerHTML = `
            <div class="text-red-500">
                Cart kosong
            </div>
        `;

        return;
    }

    let subtotal = 0;

    let html = '';

    cart.forEach(item => {

        subtotal += item.price * item.quantity;

        html += `
            <div class="flex justify-between mb-3">
                <div>
                    ${item.name} x ${item.quantity}
                </div>

                <div>
                    Rp ${(item.price * item.quantity).toLocaleString('id-ID')}
                </div>
            </div>
        `;
    });

    const shipping = 20000;

    const total = subtotal + shipping;

    html += `
        <hr class="my-4">

        <div class="flex justify-between">
            <span>Subtotal</span>
            <span>Rp ${subtotal.toLocaleString('id-ID')}</span>
        </div>

        <div class="flex justify-between mt-2">
            <span>Shipping</span>
            <span>Rp ${shipping.toLocaleString('id-ID')}</span>
        </div>

        <div class="flex justify-between mt-4 text-lg font-bold">
            <span>Total</span>
            <span class="text-brown-600">
                Rp ${total.toLocaleString('id-ID')}
            </span>
        </div>
    `;

    container.innerHTML = html;
}

document.addEventListener('DOMContentLoaded', function() {

    loadOrderSummary();

});

</script>
@endsection