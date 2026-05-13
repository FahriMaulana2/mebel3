@extends('admin.layouts.admin')

@section('title', 'Brands Management')

@section('content')
<div>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Brands</h1>
        <a href="{{ route('admin.brands.create') }}" class="bg-brown-600 text-white px-4 py-2 rounded-lg hover:bg-brown-700"><i class="fas fa-plus mr-2"></i> Add Brand</a>
    </div>
    
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50"><tr><th class="px-4 py-3 text-left">ID</th><th class="px-4 py-3 text-left">Name</th><th class="px-4 py-3 text-left">Slug</th><th class="px-4 py-3 text-left">Products</th><th class="px-4 py-3 text-left">Status</th><th class="px-4 py-3 text-left">Actions</th></tr></thead>
            <tbody>
                @forelse($brands as $brand)
                <tr class="border-b table-row">
                    <td class="px-4 py-3">{{ $brand->id }}</td>
                    <td class="px-4 py-3 font-medium">{{ $brand->name }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $brand->slug }}</td>
                    <td class="px-4 py-3">{{ $brand->products_count }}</td>
                    <td class="px-4 py-3"><span class="px-2 py-1 text-xs rounded-full {{ $brand->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $brand->is_active ? 'Active' : 'Inactive' }}</span></td>
                    <td class="px-4 py-3"><a href="{{ route('admin.brands.edit', $brand) }}" class="text-blue-600 hover:text-blue-800 mr-2"><i class="fas fa-edit"></i></a><form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" class="inline" onsubmit="return confirm('Delete this brand?')">@csrf @method('DELETE')<button type="submit" class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button></form></td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-4 py-8 text-center text-gray-500">No brands found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $brands->links() }}</div>
</div>
@endsection