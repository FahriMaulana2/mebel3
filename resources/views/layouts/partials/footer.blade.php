<footer class="bg-gray-900 text-white pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Column 1: About -->
            <div>
                <h3 class="text-xl font-playfair font-bold mb-4">Kiana Furniture</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Premium Scandinavian furniture designed for modern living. Quality craftsmanship with timeless elegance for your comfortable home.
                </p>
                <div class="flex gap-4 mt-6">
                    <a href="#" class="text-gray-400 hover:text-brown-500 transition">
                        <i class="fab fa-instagram text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-brown-500 transition">
                        <i class="fab fa-facebook-f text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-brown-500 transition">
                        <i class="fab fa-pinterest-p text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-brown-500 transition">
                        <i class="fab fa-tiktok text-xl"></i>
                    </a>
                </div>
            </div>
            
            <!-- Column 2: Quick Links -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ url('/') }}" class="text-gray-400 hover:text-brown-500 transition">Home</a></li>
                    <li><a href="{{ route('products.index') }}" class="text-gray-400 hover:text-brown-500 transition">Products</a></li>
                    <li><a href="#collections" class="text-gray-400 hover:text-brown-500 transition">Collections</a></li>
                    <li><a href="#contact" class="text-gray-400 hover:text-brown-500 transition">Contact</a></li>
                </ul>
            </div>
            
            <!-- Column 3: Customer Service -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Customer Service</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="text-gray-400 hover:text-brown-500 transition">Shipping Info</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-brown-500 transition">Returns & Exchanges</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-brown-500 transition">FAQs</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-brown-500 transition">Privacy Policy</a></li>
                </ul>
            </div>
            
            <!-- Column 4: Contact -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Contact Us</h3>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li class="flex items-center gap-3">
                        <i class="fas fa-envelope w-5"></i>
                        <span>info@kianafurniture.com</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fas fa-phone w-5"></i>
                        <span>+62 123 4567 890</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fas fa-map-marker-alt w-5"></i>
                        <span>Jepara, Indonesia</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-500 text-sm">
            <p>&copy; {{ date('Y') }} Kiana Furniture. All rights reserved.</p>
        </div>
    </div>
</footer>