@extends('layouts.app')

@section('title', $product->name . ' - Kiana Furniture')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-6 text-sm">
        <a href="{{ url('/') }}" class="text-gray-500 hover:text-brown-600">Home</a>
        <span class="mx-2 text-gray-400">/</span>
        <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-brown-600">Products</a>
        <span class="mx-2 text-gray-400">/</span>
        <span class="text-brown-600">{{ $product->name }}</span>
    </nav>
    
    <div class="grid lg:grid-cols-2 gap-12">
        <!-- Left: Image Gallery -->
        <div>
            <div class="relative bg-gray-100 rounded-2xl overflow-hidden mb-4">
                @php
                    // Tentukan URL gambar yang benar
                    $imageUrl = $product->image;
                    
                    // Jika image adalah path lokal (storage)
                    if ($imageUrl && !filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                        $imageUrl = asset('storage/' . $imageUrl);
                    }
                    // Jika image kosong, gunakan placeholder
                    if (!$imageUrl) {
                        $imageUrl = 'https://placehold.co/600x500/8B5E3C/white?text=' . urlencode($product->name);
                    }
                @endphp
                
                <img id="main-image" src="{{ $imageUrl }}" 
                     alt="{{ $product->name }}" 
                     class="w-full h-96 object-cover"
                     onerror="this.src='https://placehold.co/600x500/8B5E3C/white?text={{ urlencode($product->name) }}'">
                
                @if($product->stock <= 0)
                <div class="absolute top-4 left-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">Out of Stock</div>
                @elseif($product->is_featured)
                <div class="absolute top-4 left-4 bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-semibold">Best Seller</div>
                @endif
            </div>
            
            <!-- Additional Images (if any) -->
            @if($product->images && is_array($product->images) && count($product->images) > 0)
            <div class="grid grid-cols-4 gap-3">
                <div class="border-2 border-brown-600 rounded-lg overflow-hidden cursor-pointer" onclick="changeImage('{{ $imageUrl }}')">
                    <img src="{{ $imageUrl }}" class="w-full h-20 object-cover">
                </div>
                @foreach($product->images as $img)
                <div class="border-2 border-transparent rounded-lg overflow-hidden cursor-pointer hover:border-brown-600" onclick="changeImage('{{ asset('storage/'.$img) }}')">
                    <img src="{{ asset('storage/'.$img) }}" class="w-full h-20 object-cover">
                </div>
                @endforeach
            </div>
            @endif
        </div>
        
        <!-- Right: Product Info -->
        <div>
            <!-- Brand -->
            @if($product->brand)
            <a href="#" class="text-sm text-brown-600 font-medium hover:underline">{{ $product->brand->name }}</a>
            @endif
            
            <!-- Title -->
            <h1 class="text-3xl font-playfair font-bold text-gray-800 mt-2 mb-4">{{ $product->name }}</h1>
            
            <!-- Rating & Sales -->
            <div class="flex items-center gap-3 mb-4">
                <div class="flex items-center gap-1">
                    @php $rating = 4.8; @endphp
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= floor($rating))
                            <i class="fas fa-star text-yellow-400 text-sm"></i>
                        @elseif($i - 0.5 <= $rating)
                            <i class="fas fa-star-half-alt text-yellow-400 text-sm"></i>
                        @else
                            <i class="far fa-star text-yellow-400 text-sm"></i>
                        @endif
                    @endfor
                </div>
                <span class="text-gray-600 text-sm">4.8 ★★★★★ ({{ rand(50, 500) }} reviews)</span>
                <span class="text-gray-400">|</span>
                <span class="text-gray-600 text-sm">{{ rand(100, 2000) }} terjual</span>
            </div>
            
            <!-- Price -->
            <div class="mb-6">
                <span class="text-4xl font-bold text-brown-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
            </div>
            
            <!-- Stock Status -->
            <div class="flex items-center gap-2 mb-6">
                <i class="fas {{ $product->stock > 0 ? 'fa-check-circle text-green-500' : 'fa-times-circle text-red-500' }}"></i>
                <span class="{{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }} font-medium">
                    Stok tersedia: {{ $product->stock }} unit
                </span>
                @if($product->stock > 0 && $product->stock < 10)
                <span class="text-orange-500 text-sm">⚠️ Stok terbatas!</span>
                @endif
            </div>
            
            <!-- Description -->
            <div class="bg-gray-50 rounded-xl p-5 mb-6">
                <h3 class="font-semibold text-gray-800 mb-2">Deskripsi Produk</h3>
                <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
            </div>
            
            <!-- Quantity Selector -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Kuantitas</label>
                <div class="flex items-center gap-3">
                    <button id="qty-minus" class="w-10 h-10 border border-gray-300 rounded-lg hover:bg-gray-100 transition text-xl">-</button>
                    <span id="qty-value" class="w-12 text-center text-lg font-medium">1</span>
                    <button id="qty-plus" class="w-10 h-10 border border-gray-300 rounded-lg hover:bg-gray-100 transition text-xl">+</button>
                    <span class="text-gray-500 text-sm ml-2">Maksimal {{ min($product->stock, 10) }} unit</span>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex gap-4 mb-8">
                <button id="add-to-cart-btn" class="flex-1 bg-brown-600 text-white py-3 rounded-xl font-semibold hover:bg-brown-700 transition shadow-md flex items-center justify-center gap-2">
                    <i class="fas fa-shopping-bag"></i> Masukkan Keranjang
                </button>
                <button id="buy-now-btn" class="flex-1 bg-gray-800 text-white py-3 rounded-xl font-semibold hover:bg-gray-900 transition flex items-center justify-center gap-2">
                    <i class="fas fa-bolt"></i> Beli Sekarang
                </button>
            </div>
            
            <!-- Share -->
            <div class="flex items-center gap-6 pt-4 border-t border-gray-200">
                <button class="flex items-center gap-2 text-gray-500 hover:text-brown-600 transition">
                    <i class="far fa-heart text-lg"></i> <span>Tambah ke Favorit</span>
                </button>
                <button class="flex items-center gap-2 text-gray-500 hover:text-brown-600 transition">
                    <i class="fas fa-share-alt text-lg"></i> <span>Bagikan</span>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Related Products -->
    @if(isset($relatedProducts) && $relatedProducts->count() > 0)
    <section class="mt-16">
        <h2 class="text-2xl font-playfair font-bold text-gray-800 mb-6">Produk Terkait</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($relatedProducts as $related)
            <a href="{{ route('products.show', $related->slug) }}" class="group bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition">
                <div class="h-48 overflow-hidden">
                    @php
                        $relatedImage = $related->image;
                        if ($relatedImage && !filter_var($relatedImage, FILTER_VALIDATE_URL)) {
                            $relatedImage = asset('storage/' . $relatedImage);
                        }
                        if (!$relatedImage) {
                            $relatedImage = 'https://placehold.co/400x300/8B5E3C/white?text=' . urlencode($related->name);
                        }
                    @endphp
                    <img src="{{ $relatedImage }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" onerror="this.src='https://placehold.co/400x300/8B5E3C/white?text={{ urlencode($related->name) }}'">
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-gray-800">{{ $related->name }}</h3>
                    <p class="text-brown-600 font-bold mt-1">Rp {{ number_format($related->price, 0, ',', '.') }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </section>
    @endif
</div>

<script>
    let quantity = 1;
    const maxStock = {{ min($product->stock, 10) }};
    
    document.getElementById('qty-plus').addEventListener('click', function() {
        if (quantity < maxStock) {
            quantity++;
            document.getElementById('qty-value').textContent = quantity;
        }
    });
    
    document.getElementById('qty-minus').addEventListener('click', function() {
        if (quantity > 1) {
            quantity--;
            document.getElementById('qty-value').textContent = quantity;
        }
    });
    
    document.getElementById('add-to-cart-btn').addEventListener('click', function() {
        @php
            $imageUrl = $product->image;
            if ($imageUrl && !filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                $imageUrl = asset('storage/' . $imageUrl);
            }
            if (!$imageUrl) {
                $imageUrl = 'https://placehold.co/400x400/8B5E3C/white?text=' . urlencode($product->name);
            }
        @endphp
        addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, '{{ $imageUrl }}', quantity);
    });
    
    document.getElementById('buy-now-btn').addEventListener('click', function() {
        @php
            $imageUrl = $product->image;
            if ($imageUrl && !filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                $imageUrl = asset('storage/' . $imageUrl);
            }
            if (!$imageUrl) {
                $imageUrl = 'https://placehold.co/400x400/8B5E3C/white?text=' . urlencode($product->name);
            }
        @endphp
        addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, '{{ $imageUrl }}', quantity);
        window.location.href = '{{ route("checkout.index") }}';
    });
    
    function changeImage(src) {
        document.getElementById('main-image').src = src;
    }
</script>
@endsection