<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::active()->get();
        $featuredProducts = Product::where('is_active', true)
            ->latest()
            ->take(8)
            ->get();
        $categories = Category::where('is_active', true)
            ->orderBy('display_order')
            ->get();
        $iconCategories = Category::where('is_active', true)
            ->whereNotNull('icon_url')
            ->orderBy('display_order')
            ->take(8)
            ->get();

        return view('home', compact('banners', 'featuredProducts', 'categories', 'iconCategories'));
    }
}
