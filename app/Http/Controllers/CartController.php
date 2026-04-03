<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $products = Product::whereIn('id', array_keys($cart))->get();
        $total = $products->sum(fn($p) => $p->price * $cart[$p->id]);
        return Inertia::render('Cart/Index', [
            'cart'     => $cart,
            'products' => $products,
            'total'    => $total,
        ]);
    }

    public function add(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);
        $qty = $request->input('quantity', 1);
        $cart[$product->id] = isset($cart[$product->id])
            ? $cart[$product->id] + $qty
            : $qty;
        session()->put('cart', $cart);
        return back()->with('success', '已加入購物車！');
    }

    public function update(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);
        $cart[$product->id] = max(1, $request->input('quantity', 1));
        session()->put('cart', $cart);
        return back()->with('success', '購物車已更新！');
    }

    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);
        unset($cart[$product->id]);
        session()->put('cart', $cart);
        return back()->with('success', '已從購物車移除。');
    }
}