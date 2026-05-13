@extends('layouts.app')

@section('title', 'Home - Premium Scandinavian Furniture')

@section('content')

<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-gray-50 via-white to-gray-50 pt-16 pb-24 overflow-hidden">
    <div class="absolute top-20 right-0 w-96 h-96 bg-brown-100 rounded-full opacity-20 blur-3xl"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

        <div class="flex flex-col lg:flex-row items-center gap-12">

            <!-- LEFT -->
            <div class="lg:w-1/2 text-center lg:text-left" data-aos="fade-right">

                <span class="text-brown-600 font-semibold text-sm uppercase tracking-wider bg-brown-50 px-4 py-2 rounded-full inline-block mb-6">
                    Elevate Your Living Space
                </span>

                <h1 class="text-4xl md:text-5xl lg:text-6xl font-playfair font-bold text-gray-800 leading-tight mb-6">
                    Premium
                    <span class="text-brown-600">Scandinavian</span>
                    Furniture
                </h1>

                <p class="text-gray-600 text-lg mb-8 max-w-xl mx-auto lg:mx-0">
                    Designed for modern living. Quality craftsmanship with timeless elegance
                    for your comfortable home.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">

                    <a href="{{ route('products.index') }}"
                       class="bg-brown-600 text-white px-8 py-3 rounded-full hover:bg-brown-700 transition shadow-lg hover:shadow-xl transform hover:-translate-y-1 inline-flex items-center justify-center gap-2">

                        Shop Now
                        <i class="fas fa-arrow-right"></i>

                    </a>

                    <a href="#collections"
                       class="border-2 border-brown-600 text-brown-600 px-8 py-3 rounded-full hover:bg-brown-50 transition inline-flex items-center justify-center gap-2">

                        Learn More
                        <i class="fas fa-play"></i>

                    </a>

                </div>

            </div>

            <!-- RIGHT -->
            <div class="lg:w-1/2" data-aos="fade-left">

                <div class="relative">

                    <div class="absolute -top-6 -left-6 w-32 h-32 bg-brown-200 rounded-full opacity-50"></div>

                    <img
                        src="https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=600&h=500&fit=crop"
                        alt="Modern Scandinavian Sofa"
                        class="relative z-10 rounded-2xl shadow-2xl w-full object-cover">

                    <div class="absolute -bottom-6 -right-6 w-40 h-40 bg-yellow-300 rounded-full opacity-40"></div>

                </div>

            </div>

        </div>

    </div>
</section>

<!-- FEATURED PRODUCTS -->
<section class="py-20 bg-gray-50" id="featured">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-12" data-aos="fade-up">

            <span class="text-brown-600 font-semibold text-sm uppercase tracking-wider">
                Collection
            </span>

            <h2 class="text-3xl md:text-4xl font-playfair font-bold text-gray-800 mt-2 mb-4">
                Featured Products
            </h2>

            <div class="w-20 h-1 bg-brown-600 mx-auto rounded-full"></div>

            <p class="text-gray-600 mt-4 max-w-2xl mx-auto">
                Discover our handpicked selection of premium furniture pieces
            </p>

        </div>

        @php
            $featuredProducts = \App\Models\Product::latest()
                ->take(4)
                ->get();
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            @forelse($featuredProducts as $product)

            <div class="bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300">

                <a href="{{ url('/products/' . $product->slug) }}">

                    <div class="h-64 overflow-hidden">

                        <img
                            src="{{ $product->image }}"
                            alt="{{ $product->name }}"
                            class="w-full h-full object-cover hover:scale-105 transition duration-500">

                    </div>

                    <div class="p-5">

                        <h3 class="font-semibold text-gray-800 text-lg mb-2">
                            {{ $product->name }}
                        </h3>

                        <p class="text-brown-600 font-bold text-xl">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>

                    </div>

                </a>

            </div>

            @empty

            <div class="col-span-4 text-center py-10 text-gray-500">
                Belum ada produk tersedia
            </div>

            @endforelse

        </div>

    </div>

</section>

<!-- COMPANY SECTION -->
<section id="company-history" class="py-20 bg-[#F8F5F1] overflow-hidden">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-14 items-center">

            <!-- LEFT -->
            <div data-aos="fade-right"
                 data-aos-duration="1000">

                <!-- LABEL -->
                <div class="flex items-center gap-4 mb-5">

                    <span class="uppercase tracking-[4px] text-sm text-[#8B5E3C] font-semibold">
                        Tentang Perusahaan
                    </span>

                    <div class="w-16 h-[2px] bg-[#8B5E3C]"></div>

                </div>

                <!-- TITLE -->
                <h2 class="text-4xl md:text-5xl font-bold leading-tight text-[#2D2D2D] font-playfair">

                    Sejarah Berdirinya
                    <span class="text-[#8B5E3C]">
                        KianaFurniture
                    </span>

                </h2>

                <!-- DESCRIPTION -->
                <div class="space-y-5 mt-7">

                    <p class="text-gray-600 leading-relaxed text-lg">
                        KianaFurniture berdiri sejak tahun 2015 sebagai usaha furniture lokal
                        yang menghadirkan desain interior modern dengan kualitas premium.
                    </p>

                    <p class="text-gray-600 leading-relaxed text-lg">
                        Berawal dari workshop kecil di Jepara, kini berkembang menjadi
                        penyedia furniture terpercaya untuk rumah, kantor, cafe,
                        dan interior modern.
                    </p>

                </div>

                <!-- STATS -->
                <div class="flex flex-wrap gap-5 mt-10">

                    <!-- CARD -->
                    <div class="bg-white rounded-3xl px-8 py-6 shadow-lg border border-gray-100 min-w-[180px] hover:shadow-2xl transition duration-300">

                        <h3 class="text-4xl font-bold text-[#8B5E3C]">
                            10+
                        </h3>

                        <p class="text-gray-600 mt-2">
                            Tahun Pengalaman
                        </p>

                    </div>

                    <!-- CARD -->
                    <div class="bg-white rounded-3xl px-8 py-6 shadow-lg border border-gray-100 min-w-[180px] hover:shadow-2xl transition duration-300">

                        <h3 class="text-4xl font-bold text-[#8B5E3C]">
                            50+
                        </h3>

                        <p class="text-gray-600 mt-2">
                            Mitra Furniture
                        </p>

                    </div>

                </div>

            </div>

            <!-- RIGHT -->
            <div data-aos="fade-left"
                 data-aos-duration="1000">

                <div class="relative rounded-[32px] overflow-hidden shadow-2xl border border-gray-200 bg-white">

                    <!-- MAP -->
                    <div class="relative">

                        <!-- LOCK OVERLAY -->
                        <div class="absolute inset-0 z-20"></div>

                        <!-- GOOGLE MAP -->
                        <iframe
                            src="https://www.google.com/maps?q=-6.502801900516626,110.7165587251846&z=17&output=embed"
                            width="100%"
                            height="620"
                            style="border:0;"
                            loading="lazy"
                            class="w-full">
                        </iframe>

                        <!-- FLOATING INFO -->
                        <div class="absolute bottom-6 left-6 z-30">

                            <div class="bg-white/95 backdrop-blur-md rounded-2xl px-5 py-4 shadow-xl border border-white/50 max-w-sm">

                                <div class="flex items-center gap-4">

                                    <!-- ICON -->
                                    <div class="w-14 h-14 rounded-2xl bg-[#8B5E3C] flex items-center justify-center shadow-lg flex-shrink-0">

                                        <i class="fas fa-map-marker-alt text-white text-xl"></i>

                                    </div>

                                    <!-- TEXT -->
                                    <div>

                                        <span class="uppercase tracking-[2px] text-[11px] text-[#8B5E3C] font-semibold">
                                            Lokasi Produksi
                                        </span>

                                        <h3 class="text-xl font-bold text-[#2D2D2D] leading-tight mt-1">
                                            Jepara, Jawa Tengah
                                        </h3>

                                        <p class="text-gray-600 text-sm mt-1 leading-relaxed">
                                            Workshop utama furniture premium KianaFurniture.
                                        </p>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- CONTACT SECTION -->
<section id="contact" class="py-20 bg-[#F8F5F1] overflow-hidden">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- HEADING -->
        <div class="text-center mb-16"
             data-aos="fade-up"
             data-aos-duration="1000">

            <span class="uppercase tracking-[4px] text-sm text-[#8B5E3C] font-semibold">
                Get In Touch
            </span>

            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mt-3 font-playfair">
                Contact Us
            </h2>

            <div class="w-24 h-1 bg-[#8B5E3C] mx-auto rounded-full mt-5"></div>

            <p class="text-gray-600 mt-5 text-lg">
                We'd love to hear from you
            </p>

        </div>

        <!-- CONTENT -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-14 items-start">

            <!-- LEFT -->
            <div data-aos="fade-right"
                 data-aos-duration="1000">

                <div class="space-y-8">

                    <!-- ADDRESS -->
                    <div class="flex items-start gap-5">

                        <div class="w-14 h-14 rounded-2xl bg-[#8B5E3C]/10 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-map-marker-alt text-[#8B5E3C] text-xl"></i>
                        </div>

                        <div>

                            <h3 class="text-2xl font-semibold text-gray-800 mb-3">
                                Visit Us
                            </h3>

                            <p class="text-gray-600 leading-8 text-lg">
                                Jl. Raya Jepara KM 2, No. 88 <br>
                                Kecamatan Mlonggo, Desa Karanggondang <br>
                                Dukuh Ngipek, RT 05/RW 04 <br>
                                Kabupaten Jepara, Jawa Tengah 59352
                            </p>

                        </div>

                    </div>

                    <!-- WHATSAPP -->
                    <div class="flex items-start gap-5">

                        <div class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center flex-shrink-0">
                            <i class="fab fa-whatsapp text-green-600 text-xl"></i>
                        </div>

                        <div>

                            <h3 class="text-2xl font-semibold text-gray-800 mb-3">
                                WhatsApp
                            </h3>

                            <a href="https://wa.me/6283831520933"
                               target="_blank"
                               class="text-green-600 hover:underline text-xl font-medium">

                                +62 838 3152 0933

                            </a>

                            <p class="text-gray-500 mt-2">
                                Klik untuk chat langsung
                            </p>

                        </div>

                    </div>

                    <!-- PHONE -->
                    <div class="flex items-start gap-5">

                        <div class="w-14 h-14 rounded-2xl bg-[#8B5E3C]/10 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-phone text-[#8B5E3C] text-xl"></i>
                        </div>

                        <div>

                            <h3 class="text-2xl font-semibold text-gray-800 mb-3">
                                Call Us
                            </h3>

                            <p class="text-gray-600 leading-8 text-lg">
                                +62 838 3152 0933 (Admin) <br>
                                +62 895 3380 74209 (Owner)
                            </p>

                        </div>

                    </div>

                </div>

            </div>

            <!-- RIGHT -->
            <div data-aos="fade-left"
                 data-aos-duration="1000">

                <form id="contactForm"
                      class="bg-white rounded-[32px] p-8 shadow-xl border border-gray-100 w-full">

                    <!-- NAME & EMAIL -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">

                        <div>

                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Name *
                            </label>

                            <input type="text"
                                   id="name"
                                   required
                                   placeholder="Your Name"
                                   class="w-full h-14 border border-gray-300 rounded-xl px-5 focus:outline-none focus:ring-2 focus:ring-[#8B5E3C]">

                        </div>

                        <div>

                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Email *
                            </label>

                            <input type="email"
                                   id="email"
                                   required
                                   placeholder="Your Email"
                                   class="w-full h-14 border border-gray-300 rounded-xl px-5 focus:outline-none focus:ring-2 focus:ring-[#8B5E3C]">

                        </div>

                    </div>

                    <!-- SUBJECT -->
                    <div class="mb-5">

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Subject
                        </label>

                        <input type="text"
                               id="subject"
                               placeholder="Subject"
                               class="w-full h-14 border border-gray-300 rounded-xl px-5 focus:outline-none focus:ring-2 focus:ring-[#8B5E3C]">

                    </div>

                    <!-- MESSAGE -->
                    <div class="mb-6">

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Message *
                        </label>

                        <textarea id="message"
                                  rows="7"
                                  required
                                  placeholder="Write your message..."
                                  class="w-full border border-gray-300 rounded-xl px-5 py-4 resize-none focus:outline-none focus:ring-2 focus:ring-[#8B5E3C]"></textarea>

                    </div>

                    <!-- BUTTON -->
                    <button type="submit"
                            id="submitBtn"
                            class="w-full bg-[#8B5E3C] hover:bg-[#734C30] text-white py-4 rounded-xl font-semibold text-lg shadow-lg transition duration-300">

                        Send Message
                        <i class="fas fa-paper-plane ml-2"></i>

                    </button>

                </form>

            </div>

        </div>

    </div>

</section>

<!-- WHATSAPP SCRIPT -->
<script>
document.getElementById('contactForm').addEventListener('submit', function(e) {

    e.preventDefault();

    let name = document.getElementById('name').value.trim();
    let email = document.getElementById('email').value.trim();
    let subject = document.getElementById('subject').value.trim();
    let message = document.getElementById('message').value.trim();

    if(name === '' || email === '' || message === '') {
        alert('Mohon lengkapi form terlebih dahulu.');
        return;
    }

    const submitBtn = document.getElementById('submitBtn');
    const originalText = submitBtn.innerHTML;

    submitBtn.innerHTML =
        '<i class="fas fa-spinner fa-spin mr-2"></i> Sending...';

    submitBtn.disabled = true;

    let phoneNumber = '6283831520933';

    let text =
`Halo Admin KianaFurniture 👋

Saya ingin menghubungi KianaFurniture dengan detail berikut:

━━━━━━━━━━━━━━━
👤 Nama : ${name}
📧 Email : ${email}
📝 Subject : ${subject}
━━━━━━━━━━━━━━━

💬 Pesan:
${message}

Terima kasih.`;

    let whatsappURL =
`https://wa.me/${phoneNumber}?text=${encodeURIComponent(text)}`;

    setTimeout(() => {

        window.open(whatsappURL, '_blank');

        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;

        document.getElementById('contactForm').reset();

    }, 700);

});
</script>
@endsection