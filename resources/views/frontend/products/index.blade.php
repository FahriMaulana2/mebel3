@extends('layouts.app')

@section('title', 'Products - Kiana Furniture')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-16">

    <h1 class="text-3xl font-bold mb-8">Our Products</h1>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

        <!-- FILTER -->
        <div class="lg:col-span-1">
            <form method="GET" action="{{ route('products.index') }}" class="bg-white p-6 rounded shadow">

                <!-- SEARCH -->
                <input
                    type="text"
                    name="search"
                    placeholder="Search..."
                    value="{{ request('search') }}"
                    class="w-full border px-3 py-2 mb-4 rounded"
                >

                <!-- CATEGORY -->
                <select name="category" class="w-full border px-3 py-2 mb-4 rounded">
                    <option value="all">All Category</option>

                    <option value="living-room"
                        {{ request('category') == 'living-room' ? 'selected' : '' }}>
                        Living Room
                    </option>

                    <option value="bedroom"
                        {{ request('category') == 'bedroom' ? 'selected' : '' }}>
                        Bedroom
                    </option>

                    <option value="office"
                        {{ request('category') == 'office' ? 'selected' : '' }}>
                        Office
                    </option>

                    <option value="kitchen"
                        {{ request('category') == 'kitchen' ? 'selected' : '' }}>
                        Kitchen
                    </option>

                    <option value="dining-room"
                        {{ request('category') == 'dining-room' ? 'selected' : '' }}>
                        Dining Room
                    </option>
                </select>

                <!-- PRICE -->
                <select name="price" class="w-full border px-3 py-2 mb-4 rounded">
                    <option value="">All Price</option>

                    <option value="0-500000"
                        {{ request('price') == '0-500000' ? 'selected' : '' }}>
                        Under 500K
                    </option>

                    <option value="500000-1000000"
                        {{ request('price') == '500000-1000000' ? 'selected' : '' }}>
                        500K - 1jt
                    </option>

                    <option value="1000000-3000000"
                        {{ request('price') == '1000000-3000000' ? 'selected' : '' }}>
                        1jt - 3jt
                    </option>

                    <option value="3000000+"
                        {{ request('price') == '3000000+' ? 'selected' : '' }}>
                        Above 3jt
                    </option>
                </select>

                <!-- SORT -->
                <select name="sort" class="w-full border px-3 py-2 mb-4 rounded">
                    <option value="latest"
                        {{ request('sort') == 'latest' ? 'selected' : '' }}>
                        Newest
                    </option>

                    <option value="price_low"
                        {{ request('sort') == 'price_low' ? 'selected' : '' }}>
                        Price Low → High
                    </option>

                    <option value="price_high"
                        {{ request('sort') == 'price_high' ? 'selected' : '' }}>
                        Price High → Low
                    </option>
                </select>

                <!-- BUTTON -->
                <button
                    type="submit"
                    class="w-full bg-brown-600 text-white py-2 rounded hover:bg-brown-700 transition"
                >
                    Filter
                </button>

            </form>
        </div>

        <!-- PRODUCT GRID -->
        <div class="lg:col-span-3">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @forelse($products as $p)

                    @php
                        if ($p->image && \Illuminate\Support\Str::startsWith($p->image, 'http')) {
                            $imageUrl = $p->image;
                        } elseif ($p->image) {
                            $imageUrl = asset('storage/' . $p->image);
                        } else {
                            $imageUrl = 'https://placehold.co/300x300?text=No+Image';
                        }
                    @endphp

                    <div class="bg-white shadow rounded overflow-hidden hover:shadow-lg transition">

                        <!-- IMAGE -->
                        <a href="{{ route('products.show', $p->slug) }}">
                            <img
                                src="{{ $imageUrl }}"
                                alt="{{ $p->name }}"
                                class="w-full h-60 object-cover"
                            >
                        </a>

                        <!-- CONTENT -->
                        <div class="p-4">

                            <h3 class="font-bold text-lg mb-2">
                                {{ $p->name }}
                            </h3>

                            <p class="text-sm text-gray-500 mb-2">
                                {{ $p->brand->name ?? 'No Brand' }}
                            </p>

                            @if($p->has_discount)
                                <p class="text-brown-600 font-bold text-lg mb-2">
                                    <s class="text-gray-500">Rp {{ number_format($p->price, 0, ',', '.') }}</s>
                                </p>
                                <p class="text-brown-600 font-bold text-lg mb-4">
                                    Rp {{ number_format($p->final_price, 0, ',', '.') }}
                                </p>
                            @else
                                <p class="text-brown-600 font-bold text-lg mb-4">
                                    Rp {{ number_format($p->price, 0, ',', '.') }}
                                </p>
                            @endif

                            <a
                                href="{{ route('products.show', $p->slug) }}"
                                class="block text-center bg-black text-white py-2 rounded hover:bg-gray-800 transition"
                            >
                                View Product
                            </a>

                        </div>

                    </div>

                @empty

                    <div class="col-span-3">
                        <div class="bg-white p-8 rounded shadow text-center">
                            <p class="text-gray-500">
                                Tidak ada produk ditemukan
                            </p>
                        </div>
                    </div>

                @endforelse

            </div>

            <!-- PAGINATION -->
            <div class="mt-8">
                {{ $products->withQueryString()->links() }}
            </div>

        </div>

    </div>

</div>

@endsection

