<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{

    public function index()
    {
        $banners = Banner::orderBy('order')->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'link' => 'nullable|url',
                'order' => 'nullable|integer',
                'is_active' => 'nullable|in:0,1',
            ]);

            if (!$request->hasFile('image')) {
                return back()->withErrors(['image' => 'Please select an image file.'])->withInput();
            }

            $imagePath = $request->file('image')->store('banners', 'public');

            if (!$imagePath) {
                return back()->withErrors(['image' => 'Failed to upload image. Please try again.'])->withInput();
            }

            Banner::create([
                'title' => $request->title,
                'description' => $request->description,
                'image' => $imagePath,
                'link' => $request->link,
                'order' => $request->order ?? 0,
                'is_active' => $request->input('is_active', 0) == 1,
            ]);

            return redirect()->route('admin.banners.index')->with('success', 'Banner created successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'link' => 'nullable|url',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|in:0,1',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'link' => $request->link,
            'order' => $request->order ?? 0,
            'is_active' => $request->input('is_active', 0) == 1,
        ];

        if ($request->hasFile('image')) {
            if ($banner->image) {
                Storage::disk('public')->delete($banner->image);
            }
            $data['image'] = $request->file('image')->store('banners', 'public');
        }

        $banner->update($data);

        return redirect()->route('admin.banners.index')->with('success', 'Banner updated successfully!');
    }

    public function destroy(Banner $banner)
    {
        if ($banner->image) {
            Storage::disk('public')->delete($banner->image);
        }
        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'Banner deleted successfully!');
    }
}
