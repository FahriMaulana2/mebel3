@extends('admin.layouts.admin')

@section('title', 'Products Management')

@section('content')
<div>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Products</h1>
        <a href="{{ route('admin.products.create') }}" class="bg-brown-600 text-white px-5 py-2.5 rounded-lg hover:bg-brown-700 transition shadow-md flex items-center gap-2">
            <i class="fas fa-plus"></i> Add Product
        </a>
    </div>
    
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Image</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Name</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Price</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Stock</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Featured</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
                        <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <!-- Image Column -->
                        <td class="px-4 py-3">
                            <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden">
                                @if($product->image && filter_var($product->image, FILTER_VALIDATE_URL))
                                    <img src="{{ $product->image }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover"
                                         onerror="this.parentElement.innerHTML='<div class=\"w-full h-full bg-brown-100 flex items-center justify-center text-brown-600 font-bold text-lg\">{{ substr($product->name, 0, 1) }}</div>'">
                                @else
                                    <div class="w-full h-full bg-brown-100 flex items-center justify-center text-brown-600 font-bold text-lg">
                                        {{ substr($product->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                        </td>
                        
                        <!-- Name Column -->
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $product->name }}</td>
                        
                        <!-- Price Column -->
                        <td class="px-4 py-3 text-gray-600">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        
                        <!-- Stock Column -->
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs rounded-full font-medium 
                                {{ $product->stock <= 0 ? 'bg-red-100 text-red-700' : ($product->stock < 5 ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                        
                        <!-- Featured Column -->
                        <td class="px-4 py-3">
                            @if($product->is_featured)
                                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">
                                    <i class="fas fa-star text-xs mr-1"></i> Featured
                                </span>
                            @else
                                <span class="text-gray-400 text-xs">—</span>
                            @endif
                        </td>
                        
                        <!-- Status Column -->
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs rounded-full font-medium {{ $product->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        
                        <!-- Actions Column - BUTTONS WITH TEXT -->
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-center gap-2">
                                <!-- View Button -->
                                <a href="{{ route('products.show', $product->slug) }}" 
                                   target="_blank"
                                   class="bg-teal-500 text-white px-3 py-1.5 rounded-lg hover:bg-teal-600 transition text-xs font-medium flex items-center gap-1"
                                   title="View Product">
                                    <i class="fas fa-eye text-xs"></i> View
                                </a>
                                
                                <!-- Edit Button -->
                                <a href="{{ route('admin.products.edit', $product) }}" 
                                   class="bg-blue-500 text-white px-3 py-1.5 rounded-lg hover:bg-blue-600 transition text-xs font-medium flex items-center gap-1"
                                   title="Edit Product">
                                    <i class="fas fa-edit text-xs"></i> Edit
                                </a>
                                
                                <!-- Delete Button -->
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete this product?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-500 text-white px-3 py-1.5 rounded-lg hover:bg-red-600 transition text-xs font-medium flex items-center gap-1"
                                            title="Delete Product">
                                        <i class="fas fa-trash text-xs"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                            <i class="fas fa-box-open text-4xl mb-2 block"></i>
                            No products found. Click "Add Product" to create one.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    @if($products->hasPages())
    <div class="mt-6">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection