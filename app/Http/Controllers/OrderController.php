<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()
            ->orders()
            ->with('items.product')
            ->latest()
            ->get();
        return Inertia::render('Orders/Index', ['orders' => $orders]);
    }

    public function store()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', '購物車是空的！');
        }

        $products = Product::whereIn('id', array_keys($cart))->get();
        $total = $products->sum(fn($p) => $p->price * $cart[$p->id]);

        $order = Order::create([
            'user_id' => auth()->id(),
            'total'   => $total,
            'status'  => 'pending',
        ]);

        foreach ($products as $product) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $product->id,
                'quantity'   => $cart[$product->id],
                'price'      => $product->price,
            ]);
        }

        session()->forget('cart');
        return redirect()->route('orders.index')->with('success', '訂單已成立！');
    }
}