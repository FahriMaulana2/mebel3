@extends('admin.layouts.app')

@section('title', 'Brand Details - Kiana Furniture')

@section('header', 'Brand: ' . $brand->name)

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6">
    <p class="text-gray-600 mb-2">ID: {{ $brand->id }}</p>
    <p class="text-gray-900 text-lg font-semibold">Name: {{ $brand->name }}</p>
    <p class="text-gray-600 mt-4">Products: {{ $brand->products->count() }}</p>
</div>

<div class="mt-4">
    <a href="{{ route('admin.brands.index') }}" class="text-[#8B5E3C] hover:underline">← Back to Brands</a>
</div>
@endsection
