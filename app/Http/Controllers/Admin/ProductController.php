<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(15);
        return Inertia::render('Admin/Products/Index', ['products' => $products]);
    }

    public function create()
    {
        return Inertia::render('Admin/Products/Form', ['product' => null]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'category'    => 'nullable|string|max:100',
            'image'       => 'nullable|url',
        ]);

        Product::create($validated);
        return redirect()->route('admin.products.index')->with('success', '商品已新增！');
    }

    public function edit(Product $product)
    {
        return Inertia::render('Admin/Products/Form', ['product' => $product]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'category'    => 'nullable|string|max:100',
            'image'       => 'nullable|url',
        ]);

        $product->update($validated);
        return redirect()->route('admin.products.index')->with('success', '商品已更新！');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', '商品已刪除！');
    }
}
