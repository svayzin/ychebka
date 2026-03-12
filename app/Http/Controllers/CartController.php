<?php
// app/Http/Controllers/CartController.php
namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Страница корзины
  public function index()
{
    // Проверяем авторизацию
    if (!auth()->check()) {
        return redirect()->route('login')
            ->with('error', 'Для просмотра корзины необходимо войти в систему');
    }
    
    // Получаем товары в корзине
    $cartItems = CartItem::where('user_id', auth()->id())
        ->with('product')
        ->get();
    
    // Рассчитываем общую сумму
    $total = 0;
    foreach ($cartItems as $item) {
        $total += $item->quantity * $item->product->price;
    }
    
    // Передаем в представление
    return view('cart.index', [
        'cartItems' => $cartItems,
        'total' => $total
    ]);
}

   public function addItem(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1|max:10'
    ]);

    if (!Auth::check()) {
        return response()->json([
            'success' => false,
            'message' => 'Для добавления в корзину необходимо войти в систему',
            'require_login' => true
        ]);
    }

    $product = Product::findOrFail($request->product_id);

    // Проверяем, есть ли уже этот товар в корзине
    $cartItem = CartItem::where('user_id', Auth::id())
        ->where('product_id', $request->product_id)
        ->first();

    if ($cartItem) {
        // Если товар уже есть, увеличиваем количество
        $newQuantity = $cartItem->quantity + $request->quantity;
        if ($newQuantity > 10) {
            $newQuantity = 10;
        }
        $cartItem->quantity = $newQuantity;
        $cartItem->save();
    } else {
        // Если товара нет, добавляем новый
        CartItem::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'quantity' => $request->quantity
        ]);
    }

    // Получаем общее количество товаров в корзине
    $cartCount = CartItem::where('user_id', Auth::id())->sum('quantity');

    return response()->json([
        'success' => true,
        'message' => 'Товар добавлен в корзину',
        'cart_count' => $cartCount
    ]);
}

    // Традиционное добавление (для форм)
    public function add(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Для добавления в корзину необходимо войти в систему');
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:10'
        ]);

        $product = Product::findOrFail($request->product_id);

        $cartItem = CartItem::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            CartItem::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity
            ]);
        }

        return redirect()->back()->with('success', 'Товар добавлен в корзину');
    }

    // Обновление количества
    public function update(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Требуется авторизация'
            ], 401);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1|max:10'
        ]);

        $cartItem = CartItem::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        $cartItems = $this->getCartItems();
        $total = $this->calculateTotal($cartItems);

        return response()->json([
            'success' => true,
            'total' => $total,
            'item_total' => $cartItem->quantity * $cartItem->product->price
        ]);
    }

    // Удаление из корзины
    public function remove($id)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Требуется авторизация'
            ], 401);
        }

        $cartItem = CartItem::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $cartItem->delete();

        $cartItems = $this->getCartItems();
        $total = $this->calculateTotal($cartItems);

        return response()->json([
            'success' => true,
            'total' => $total,
            'cart_count' => $this->getCartCount()
        ]);
    }

    // Оформление заказа
    public function checkout(Request $request)
{
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Для оформления заказа необходимо войти в систему');
    }

    $request->validate([
        'delivery_type' => 'required|in:delivery,pickup',
        'notes' => 'nullable|string|max:1000',
        'payment_method' => 'required|in:card,online,cash',
        
        // Для доставки
        'city' => 'nullable|string|max:255',
        'street' => 'required_if:delivery_type,delivery|nullable|string|max:255',
        'house' => 'required_if:delivery_type,delivery|nullable|string|max:50',
        'apartment' => 'nullable|string|max:50',
        'entrance' => 'nullable|string|max:50',
        'floor' => 'nullable|string|max:50',
        'intercom' => 'nullable|string|max:50',
        
        // Для самовывоза
        'pickup_address' => 'required_if:delivery_type,pickup|nullable|string|max:500',
    ]);

    $cartItems = $this->getCartItems();
    
    if ($cartItems->isEmpty()) {
        return back()->with('error', 'Корзина пуста');
    }

    $total = $this->calculateTotal($cartItems);

    // Формируем полный адрес
    $address = '';
    if ($request->delivery_type === 'delivery') {
        $addressParts = [];
        if ($request->city) $addressParts[] = $request->city;
        if ($request->street) $addressParts[] = 'ул. ' . $request->street;
        if ($request->house) $addressParts[] = 'д. ' . $request->house;
        if ($request->apartment) $addressParts[] = 'кв. ' . $request->apartment;
        if ($request->entrance) $addressParts[] = 'под. ' . $request->entrance;
        if ($request->floor) $addressParts[] = 'эт. ' . $request->floor;
        if ($request->intercom) $addressParts[] = 'домофон: ' . $request->intercom;
        
        $address = implode(', ', $addressParts);
    } else {
        $address = $request->pickup_address;
    }

    // Создаем заказ
    $user = Auth::user();
    $order = Order::create([
        'user_id' => $user->id,
        'full_name' => $user->full_name ?? '',
        'phone' => $user->phone ?? '',
        'email' => $user->email,
        'address' => $address,
        'city' => $request->city,
        'street' => $request->street,
        'house' => $request->house,
        'apartment' => $request->apartment,
        'entrance' => $request->entrance,
        'floor' => $request->floor,
        'intercom' => $request->intercom,
        'total_amount' => $total,
        'comment' => $request->notes,
        'delivery_type' => $request->delivery_type,
        'payment_method' => $request->payment_method,
        'status' => 'pending',
    ]);

    // Добавляем товары в заказ
    foreach ($cartItems as $cartItem) {
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $cartItem->product_id,
            'quantity' => $cartItem->quantity,
            'price' => $cartItem->product->price,
        ]);

        // Удаляем из корзины
        $cartItem->delete();
    }

    return redirect()->route('orders.show', $order->id)
        ->with('success', 'Заказ успешно оформлен! Номер заказа: #' . $order->id);
}

    // Количество товаров в корзине
    public function getCount()
    {
        $count = 0;
        
        if (Auth::check()) {
            $count = CartItem::where('user_id', Auth::id())->sum('quantity');
        }

        return response()->json(['count' => $count]);
    }

    // Вспомогательные методы
    private function getCartItems()
    {
        if (Auth::check()) {
            return CartItem::where('user_id', Auth::id())
                ->with('product')
                ->get();
        }

        return collect();
    }

    private function calculateTotal($cartItems)
    {
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item->quantity * $item->product->price;
        }
        return $total;
    }

    private function getCartCount()
    {
        if (Auth::check()) {
            return CartItem::where('user_id', Auth::id())->sum('quantity');
        }
        
        return 0;
    }

    public function placeOrder(Request $request)
{
    // Валидация
    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'address' => 'required|string|max:500',
        'payment_method' => 'required|in:cash,card,online',
        'email' => 'nullable|email',
        'comment' => 'nullable|string|max:1000'
    ]);

    $cart = Session::get('cart', []);
    
    if (empty($cart)) {
        return redirect()->back()->with('error', 'Корзина пуста');
    }

    try {
        // Создаем заказ
        $order = new Order();
        $order->user_id = Auth::id();
        $order->order_number = 'ORD-' . strtoupper(uniqid());
        $order->customer_name = $request->name;
        $order->customer_phone = $request->phone;
        $order->customer_email = $request->email;
        $order->delivery_address = $request->address;
        $order->comment = $request->comment;
        $order->payment_method = $request->payment_method;
        $order->subtotal = $this->getTotal($cart);
        $order->delivery_fee = $order->subtotal >= 1500 ? 0 : 300;
        $order->total = $order->subtotal + $order->delivery_fee;
        $order->status = 'new';
        $order->save();

        // Сохраняем товары в заказе
        foreach ($cart as $item) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_name = $item['name'];
            $orderItem->price = $item['price'];
            $orderItem->quantity = $item['quantity'];
            $orderItem->weight = $item['weight'] ?? null;
            $orderItem->save();
        }

        // Очищаем корзину
        Session::forget('cart');

        return redirect()->route('cart.success', ['order' => $order->order_number])
            ->with('success', 'Заказ успешно оформлен!');

    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Ошибка при оформлении заказа: ' . $e->getMessage())
            ->withInput();
    }
}
}