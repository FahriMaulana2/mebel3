@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-16">
    <h1 class="text-3xl font-playfair font-bold text-gray-800 mb-8">Shopping Cart</h1>
    
    <div id="cart-container">
        <div id="empty-cart" class="text-center py-12 hidden">
            <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 text-lg">Your cart is empty</p>
            <a href="{{ route('products.index') }}" class="inline-block mt-4 bg-brown-600 text-white px-6 py-2 rounded-full hover:bg-brown-700">
                Continue Shopping
            </a>
        </div>
        
        <div id="cart-content"></div>
    </div>
</div>

<script>
function displayCart() {
    const cart = JSON.parse(localStorage.getItem('kiana_cart') || '[]');
    const container = document.getElementById('cart-content');
    const emptyCartDiv = document.getElementById('empty-cart');
    
    if (cart.length === 0) {
        container.innerHTML = '';
        emptyCartDiv.classList.remove('hidden');
        return;
    }
    
    emptyCartDiv.classList.add('hidden');
    
    let html = `
        <div class="flex flex-col lg:flex-row gap-8">
            <div class="lg:w-2/3">
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="px-4 py-3 text-left">Product</th>
                                <th class="px-4 py-3 text-center">Price</th>
                                <th class="px-4 py-3 text-center">Quantity</th>
                                <th class="px-4 py-3 text-center">Subtotal</th>
                                <th class="px-4 py-3 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
    `;
    
    let total = 0;
    for (let i = 0; i < cart.length; i++) {
        const item = cart[i];
        const subtotal = item.price * item.quantity;
        total += subtotal;
        
        html += `
            <tr class="border-b">
                <td class="px-4 py-3">
                    <div class="flex items-center gap-3">
                        <img src="${item.image || '/images/placeholder.jpg'}" class="w-16 h-16 object-cover rounded">
                        <span class="font-medium">${item.name}</span>
                    </div>
                </td>
                <td class="px-4 py-3 text-center">Rp ${item.price.toLocaleString('id-ID')}</td>
                <td class="px-4 py-3 text-center">
                    <button onclick="updateQty(${item.id}, ${item.quantity - 1})">-</button>
                    <span class="mx-2">${item.quantity}</span>
                    <button onclick="updateQty(${item.id}, ${item.quantity + 1})">+</button>
                </td>
                <td class="px-4 py-3 text-center">Rp ${subtotal.toLocaleString('id-ID')}</td>
                <td class="px-4 py-3 text-center">
                    <button onclick="removeItem(${item.id})" class="text-red-500">Hapus</button>
                </td>
            </tr>
        `;
    }
    
    const shipping = 20000;
    const grandTotal = total + shipping;

    html += `
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="lg:w-1/3">
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-xl font-semibold mb-4">Order Summary</h3>

                    <div class="flex justify-between mb-2">
                        <span>Subtotal</span>
                        <span>Rp ${total.toLocaleString('id-ID')}</span>
                    </div>

                    <div class="flex justify-between mb-2">
                        <span>Shipping</span>
                        <span>Rp ${shipping.toLocaleString('id-ID')}</span>
                    </div>

                    <div class="flex justify-between font-bold text-lg border-t pt-2">
                        <span>Total</span>
                        <span class="text-brown-600">Rp ${grandTotal.toLocaleString('id-ID')}</span>
                    </div>

                    <!-- ✅ FIX UTAMA DI SINI -->
                    <a href="{{ route('checkout.index') }}" 
                       class="block w-full bg-brown-600 text-white text-center py-3 rounded-lg mt-6 hover:bg-brown-700 transition">
                        Proceed to Checkout
                    </a>

                    <a href="{{ route('products.index') }}" class="block w-full text-center text-brown-600 mt-4 hover:underline">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    `;
    
    container.innerHTML = html;
}

function updateQty(id, newQty) {
    if (newQty <= 0) {
        removeItem(id);
        return;
    }

    let cart = JSON.parse(localStorage.getItem('kiana_cart') || '[]');
    const item = cart.find(i => i.id == id);

    if (item) {
        item.quantity = newQty;
        localStorage.setItem('kiana_cart', JSON.stringify(cart));
        displayCart();
        updateCartBadge();
    }
}

function removeItem(id) {
    let cart = JSON.parse(localStorage.getItem('kiana_cart') || '[]');
    cart = cart.filter(i => i.id != id);
    localStorage.setItem('kiana_cart', JSON.stringify(cart));
    displayCart();
    updateCartBadge();
}

function updateCartBadge() {
    const cart = JSON.parse(localStorage.getItem('kiana_cart') || '[]');
    const count = cart.reduce((sum, item) => sum + item.quantity, 0);
    const badge = document.getElementById('cart-badge');

    if (badge) {
        if (count > 0) {
            badge.textContent = count;
            badge.classList.remove('hidden');
        } else {
            badge.classList.add('hidden');
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    displayCart();
    updateCartBadge();
});
</script>
@endsection