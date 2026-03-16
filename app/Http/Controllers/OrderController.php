<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the user's orders.
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->with('items.product')
            ->firstOrFail();

        return view('orders.show', compact('order'));
    }

    /**
     * Cancel the specified order.
     */
    public function cancel($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($order->status === 'new') {
            $order->status = 'cancelled';
            $order->save();
            
            return redirect()->back()->with('success', 'Заказ отменен');
        }

        return redirect()->back()->with('error', 'Заказ нельзя отменить');
    }

    /**
     * Repeat order (add all items to cart).
     */
    public function repeat($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->with('items')
            ->firstOrFail();

        $cart = Session::get('cart', []);
        
        foreach ($order->items as $item) {
            $cart[] = [
                'id' => uniqid(),
                'name' => $item->product_name,
                'price' => $item->price,
                'weight' => $item->weight,
                'quantity' => $item->quantity
            ];
        }
        
        Session::put('cart', $cart);

        return redirect()->route('cart.index')
            ->with('success', 'Товары добавлены в корзину');
    }
}