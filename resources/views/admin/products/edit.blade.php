@extends('admin.layouts.admin')

@section('title', 'Edit Product')

@section('content')
<div class="max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Product: {{ $product->name }}</h1>
    
    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-md p-6">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Product Name *</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full border rounded-lg px-4 py-2">
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
            <select name="category" class="w-full border rounded-lg px-4 py-2">
                <option value="living-room" {{ $product->category == 'living-room' ? 'selected' : '' }}>Living Room</option>
                <option value="bedroom" {{ $product->category == 'bedroom' ? 'selected' : '' }}>Bedroom</option>
                <option value="office" {{ $product->category == 'office' ? 'selected' : '' }}>Home Office</option>
                <option value="decor" {{ $product->category == 'decor' ? 'selected' : '' }}>Decor</option>
            </select>
        </div>
        
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Price *</label>
                <input type="number" name="price" value="{{ old('price', $product->price) }}" required class="w-full border rounded-lg px-4 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Stock *</label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required class="w-full border rounded-lg px-4 py-2">
            </div>
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Brand</label>
            <select name="brand_id" class="w-full border rounded-lg px-4 py-2">
                <option value="">Select Brand (optional)</option>
                @foreach($brands as $brand)
                <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea name="description" rows="5" class="w-full border rounded-lg px-4 py-2">{{ old('description', $product->description) }}</textarea>
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Current Image</label>
            @if($product->image)
                <img src="{{ $product->image }}" class="w-24 h-24 object-cover rounded mb-2" onerror="this.style.display='none'">
            @endif
            <input type="file" name="image" accept="image/*" class="w-full border rounded-lg px-4 py-2">
        </div>
        
        <div class="flex gap-4 mb-6">
            <label class="flex items-center gap-2">
                <input type="checkbox" name="is_featured" value="1" {{ $product->is_featured ? 'checked' : '' }}> 
                <span class="text-sm">Featured Product</span>
            </label>
            <label class="flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }}> 
                <span class="text-sm">Active</span>
            </label>
        </div>
        
        <!-- TOMBOL UPDATE DAN CANCEL -->
        <div class="flex gap-3 mt-6">
            <button type="submit" class="bg-brown-600 text-white px-6 py-2 rounded-lg hover:bg-brown-700 transition">
                <i class="fas fa-save mr-2"></i> Update Product
            </button>
            <a href="{{ route('admin.products.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection