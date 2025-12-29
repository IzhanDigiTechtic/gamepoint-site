<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::with(['category', 'brand'])->latest()->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        $brands = Brand::where('is_active', true)->get();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku',
            'product_code' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string',
            'specifications' => 'nullable|array',
            'condition' => 'nullable|in:new,used,refurbished',
            'has_warranty' => 'nullable|in:0,1',
            'warranty_months' => 'nullable|integer|min:0',
            'is_active' => 'nullable|in:0,1',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->input('is_active', 0) == 1;
        $data['has_warranty'] = $request->input('has_warranty', 0) == 1;
        $data['condition'] = $request->input('condition', 'new');
        if (!$data['has_warranty']) {
            $data['warranty_months'] = null;
        }
        
        // Handle specifications as JSON
        if ($request->has('specifications')) {
            $specs = [];
            if (isset($request->specifications['key']) && isset($request->specifications['value'])) {
                foreach ($request->specifications['key'] as $index => $key) {
                    $value = $request->specifications['value'][$index] ?? '';
                    if (!empty($key) && !empty($value)) {
                        $specs[$key] = $value;
                    }
                }
            }
            $data['specifications'] = !empty($specs) ? $specs : null;
        }

        // Update price_updated_at when price changes
        if ($request->has('price') || $request->has('sale_price')) {
            $data['price_updated_at'] = now();
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::create($data);

        // Handle multiple images
        if ($request->hasFile('images')) {
            $mainImageSet = false;
            foreach ($request->file('images') as $index => $imageFile) {
                $imagePath = $imageFile->store('products', 'public');
                $isMain = !$mainImageSet && ($index === 0 || $request->input("main_image_index") == $index);
                if ($isMain) {
                    $mainImageSet = true;
                }
                
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imagePath,
                    'is_main' => $isMain,
                    'order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->get();
        $brands = Brand::where('is_active', true)->get();
        $product->load('images');
        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'product_code' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string',
            'specifications' => 'nullable|array',
            'condition' => 'nullable|in:new,used,refurbished',
            'has_warranty' => 'nullable|in:0,1',
            'warranty_months' => 'nullable|integer|min:0',
            'is_active' => 'nullable|in:0,1',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->input('is_active', 0) == 1;
        $data['has_warranty'] = $request->input('has_warranty', 0) == 1;
        $data['condition'] = $request->input('condition', 'new');
        if (!$data['has_warranty']) {
            $data['warranty_months'] = null;
        }
        
        // Handle specifications as JSON
        if ($request->has('specifications')) {
            $specs = [];
            if (isset($request->specifications['key']) && isset($request->specifications['value'])) {
                foreach ($request->specifications['key'] as $index => $key) {
                    $value = $request->specifications['value'][$index] ?? '';
                    if (!empty($key) && !empty($value)) {
                        $specs[$key] = $value;
                    }
                }
            }
            $data['specifications'] = !empty($specs) ? $specs : null;
        }

        // Update price_updated_at when price changes
        $oldPrice = $product->price;
        $oldSalePrice = $product->sale_price;
        if ($request->input('price') != $oldPrice || $request->input('sale_price') != $oldSalePrice) {
            $data['price_updated_at'] = now();
        }

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        // Handle multiple images
        if ($request->hasFile('images')) {
            $maxOrder = $product->images()->max('order') ?? -1;
            foreach ($request->file('images') as $index => $imageFile) {
                $imagePath = $imageFile->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imagePath,
                    'is_main' => false,
                    'order' => ++$maxOrder,
                ]);
            }
        }

        // Handle setting main image
        if ($request->has('main_image_id')) {
            $product->images()->update(['is_main' => false]);
            $product->images()->where('id', $request->main_image_id)->update(['is_main' => true]);
        }

        // Handle image deletion
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $productImage = ProductImage::find($imageId);
                if ($productImage && $productImage->product_id == $product->id) {
                    Storage::disk('public')->delete($productImage->image_path);
                    $productImage->delete();
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        // Delete all product images
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }
        
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }
}
