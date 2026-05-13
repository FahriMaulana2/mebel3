<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // 🔥 START QUERY
        $query = Product::where('is_active', true);

        // ================== SEARCH ==================
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // ================== CATEGORY ==================
        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // ================== PRICE ==================
        if ($request->filled('price')) {

            switch ($request->price) {
                case '0-500000':
                    $query->where('price', '<', 500000);
                    break;

                case '500000-1000000':
                    $query->whereBetween('price', [500000, 1000000]);
                    break;

                case '1000000-3000000':
                    $query->whereBetween('price', [1000000, 3000000]);
                    break;

                case '3000000+':
                    $query->where('price', '>', 3000000);
                    break;
            }
        }

        // ================== SORT ==================
        if ($request->sort === 'price_low') {
            $query->orderBy('price', 'asc');

        } elseif ($request->sort === 'price_high') {
            $query->orderBy('price', 'desc');

        } else {
            $query->latest(); // default
        }

        // ================== GET DATA ==================
        $products = $query->get();

        return view('frontend.products.index', compact('products'));
    }

    public function show($slug)
    {
        // 🔥 PRODUCT DETAIL
        $product = Product::with('brand')
            ->where('slug', $slug)
            ->firstOrFail();

        // 🔥 RELATED PRODUCTS
        $relatedProducts = Product::where('is_active', true)
            ->where('id', '!=', $product->id)
            ->where(function ($q) use ($product) {
                $q->where('category', $product->category)
                  ->orWhere('brand_id', $product->brand_id);
            })
            ->latest()
            ->limit(4)
            ->get();

        return view('frontend.products.show', compact('product', 'relatedProducts'));
    }
}