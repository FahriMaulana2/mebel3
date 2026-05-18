<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('brand')->latest()->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $brands = Brand::where('is_active', true)->get();

        return view('admin.products.create', compact('brands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'nullable|string',

            // DISKON
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'discount_start' => 'nullable|date',
            'discount_end' => 'nullable|date|after_or_equal:discount_start',
            'is_discount' => 'nullable|boolean',

            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'image_url' => 'nullable|url',

            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        /*
        | IMAGE UPLOAD
        */
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        } elseif ($request->image_url) {
            $validated['image'] = $request->image_url;
        }

        /*
        | CONVERT DATE SAFELY
        */
        if ($request->discount_start) {
            $validated['discount_start'] = Carbon::parse($request->discount_start);
        }

        if ($request->discount_end) {
            $validated['discount_end'] = Carbon::parse($request->discount_end);
        }

        /*
        | PRODUCT DATA
        */
        $validated['slug'] = Str::slug($validated['name']);

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_discount'] = $request->boolean('is_discount');

        $validated['discount_percentage'] = $request->discount_percentage ?? 0;

        Product::create($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product created successfully!');
    }

    public function edit(Product $product)
    {
        $brands = Brand::where('is_active', true)->get();

        return view('admin.products.edit', compact('product', 'brands'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'nullable|string',

            // DISKON
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'discount_start' => 'nullable|date',
            'discount_end' => 'nullable|date|after_or_equal:discount_start',
            'is_discount' => 'nullable|boolean',

            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'image_url' => 'nullable|url',

            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        /*
        | IMAGE
        */
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        } elseif ($request->image_url) {
            $validated['image'] = $request->image_url;
        }

        /*
        | CONVERT DATE SAFELY
        */
        if ($request->discount_start) {
            $validated['discount_start'] = Carbon::parse($request->discount_start);
        }

        if ($request->discount_end) {
            $validated['discount_end'] = Carbon::parse($request->discount_end);
        }

        /*
        | PRODUCT DATA
        */
        $validated['slug'] = Str::slug($validated['name']);

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_discount'] = $request->boolean('is_discount');

        $validated['discount_percentage'] = $request->discount_percentage ?? 0;

        $product->update($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted successfully!');
    }
}