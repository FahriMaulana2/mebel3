@extends('admin.layouts.admin')

@section('title', 'Edit Brand')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Brand: {{ $brand->name }}</h1>
    <form action="{{ route('admin.brands.update', $brand) }}" method="POST" class="bg-white rounded-xl shadow-md p-6">
        @csrf @method('PUT')
        <div class="mb-4"><label class="block text-sm font-medium text-gray-700 mb-1">Brand Name *</label><input type="text" name="name" value="{{ old('name', $brand->name) }}" required class="w-full border rounded-lg px-4 py-2"></div>
        <div class="mb-4"><label class="block text-sm font-medium text-gray-700 mb-1">Description</label><textarea name="description" rows="4" class="w-full border rounded-lg px-4 py-2">{{ old('description', $brand->description) }}</textarea></div>
        <div class="mb-6"><label class="flex items-center gap-2"><input type="checkbox" name="is_active" value="1" {{ $brand->is_active ? 'checked' : '' }}> <span class="text-sm">Active</span></label></div>
        <div class="flex gap-3"><button type="submit" class="bg-brown-600 text-white px-6 py-2 rounded-lg hover:bg-brown-700">Update Brand</button><a href="{{ route('admin.brands.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400">Cancel</a></div>
    </form>
</div>
@endsection