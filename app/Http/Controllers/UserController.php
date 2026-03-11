<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Reservation;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function profile(Request $request)
    {
        $user = Auth::user();
        
        // Получаем последние заказы пользователя
        $orders = Order::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        // Получаем последние бронирования
        $reservations = Reservation::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->limit(5)
            ->get();
        
        // Получаем количество товаров в корзине
        $cartCount = CartItem::where('user_id', $user->id)->sum('quantity');
            
        return view('user.profile', compact('user', 'orders', 'reservations', 'cartCount'));
    }
    
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
        ]);
        
        $user->update($request->only(['full_name', 'email', 'phone']));
        
        return back()->with('success', 'Профиль обновлен');
    }
}