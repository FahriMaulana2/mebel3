console.log('cart.js mulai dijalankan');

function addToCart(id, name, price, image, quantity = 1) {
    console.log('addToCart DIPANGGIL!', id);

    let cart = JSON.parse(localStorage.getItem('kiana_cart') || '[]');

    let found = cart.find(item => item.id == id);

    if (found) {
        found.quantity += quantity;
    } else {
        cart.push({
            id: id,
            name: name,
            price: price,
            image: image || '',
            quantity: quantity
        });
    }

    localStorage.setItem('kiana_cart', JSON.stringify(cart));

    alert(name + ' berhasil ditambahkan ke keranjang!');
    updateCartBadge();
}

function updateCartBadge() {
    let cart = JSON.parse(localStorage.getItem('kiana_cart') || '[]');

    let count = cart.reduce((sum, item) => sum + item.quantity, 0);

    console.log('Update badge:', count);

    let badge = document.getElementById('cart-badge');

    if (!badge) return;

    if (count > 0) {
        badge.textContent = count;
        badge.classList.remove('hidden');
    } else {
        badge.classList.add('hidden');
    }
}

// global access
window.addToCart = addToCart;
window.updateCartBadge = updateCartBadge;

document.addEventListener('DOMContentLoaded', function () {
    updateCartBadge();
});

console.log('cart.js selesai dijalankan');