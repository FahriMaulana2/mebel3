<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with('brand')
            ->where('is_active', true)
            ->where('is_featured', true)
            ->latest()
            ->take(8)
            ->get();

        $newProducts = Product::with('brand')
            ->where('is_active', true)
            ->latest()
            ->take(4)
            ->get();

        return view('frontend.home', compact('featuredProducts', 'newProducts'));
    }
}