@extends('layouts.app')

@section('title', 'Checkout Berhasil - Kiana Furniture')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-20">

    <div class="bg-white rounded-2xl shadow-lg p-8 text-center">

        <!-- ICON -->
        <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-check text-4xl text-green-600"></i>
        </div>

        <!-- TITLE -->
        <h1 class="text-4xl font-playfair font-bold text-gray-800 mb-4">
            Checkout Berhasil!
        </h1>

        <p class="text-gray-600 mb-2">
            Pesanan Anda berhasil dibuat.
        </p>

        <p class="text-gray-600 mb-6">
            Nomor Order:
            <span class="font-bold text-brown-600">
                {{ $order->order_number }}
            </span>
        </p>

        <!-- ORDER INFO -->
        <div class="bg-gray-50 rounded-xl p-6 text-left mb-8">

            <h2 class="text-xl font-semibold mb-4">
                Detail Pemesan
            </h2>

            <div class="space-y-2 text-gray-700">

                <div class="flex justify-between">
                    <span>Nama</span>
                    <span class="font-medium">{{ $order->fullname }}</span>
                </div>

                <div class="flex justify-between">
                    <span>No HP</span>
                    <span class="font-medium">{{ $order->phone }}</span>
                </div>

                <div class="flex justify-between">
                    <span>Kota</span>
                    <span class="font-medium">{{ $order->city }}</span>
                </div>

                <div class="flex justify-between">
                    <span>Kurir</span>
                    <span class="font-medium">{{ $order->courier }}</span>
                </div>

                <div class="flex justify-between border-t pt-3 mt-3">
                    <span>Total</span>
                    <span class="font-bold text-lg text-brown-600">
                        Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                    </span>
                </div>

            </div>
        </div>

        <!-- BUTTONS -->
        <div class="flex flex-col md:flex-row gap-4 justify-center">

            <!-- WHATSAPP -->
            <a href="{{ $whatsappUrl }}"
               target="_blank"
               class="bg-green-500 hover:bg-green-600 text-white px-8 py-4 rounded-xl font-semibold transition flex items-center justify-center gap-3">

                <i class="fab fa-whatsapp text-2xl"></i>
                Kirim Pesanan ke WhatsApp

            </a>

            <!-- CANCEL -->
            <a href="{{ url('/') }}"
               class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-8 py-4 rounded-xl font-semibold transition">

                Batal

            </a>

        </div>

        <!-- INFO -->
        <div class="mt-8 text-sm text-gray-500">
            Setelah WhatsApp terbuka, cukup tekan tombol kirim untuk mengirim pesanan ke admin.
        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // otomatis buka whatsapp
    setTimeout(() => {
        window.open("{{ $whatsappUrl }}", '_blank');
    }, 1000);

    // kosongkan cart
    localStorage.removeItem('kiana_cart');

    // update badge
    if (typeof updateCartBadge === 'function') {
        updateCartBadge();
    }

});
</script>
@endsection