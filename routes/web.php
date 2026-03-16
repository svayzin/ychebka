<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TableBookingController;

// Главная страница
Route::get('/', [HomeController::class, 'index'])->name('home');

// Страница меню с категориями
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/menu/category/{slug}', [MenuController::class, 'category'])->name('menu.category');

// 
Route::get('/api/tables', [TableBookingController::class, 'tables']);
Route::get('/api/table-availability', [TableBookingController::class, 'availability']);
Route::post('/api/table-reservations', [TableBookingController::class, 'store']);
// Роут страницы бронирования
Route::get('/booking', function () {
    return view('booking.index');
})->name('booking.index');

// ============= АУТЕНТИФИКАЦИЯ =============
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Выход
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/table-reservations', [TableBookingController::class, 'userIndex'])
        ->name('table-reservations.index');
});

// ============= ЗАЩИЩЕННЫЕ МАРШРУТЫ =============
Route::middleware('auth')->group(function () {
    // Профиль пользователя
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
    
    // Корзина
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add', [CartController::class, 'add'])->name('add');
        Route::post('/add-item', [CartController::class, 'addItem'])->name('add-item');
        Route::put('/update/{id}', [CartController::class, 'update'])->name('update');
        Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('remove');
        Route::get('/count', [CartController::class, 'getCount'])->name('count');
        Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
    });

    Route::get('/api/product/{id}', function($id) {
        try {
            $product = \App\Models\Product::with('category')->findOrFail($id);
            return response()->json($product);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Product not found'], 404);
        }
    })->name('api.product');

    // Заказы
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/{id}', [OrderController::class, 'show'])->name('show');
    });

});

// ============= АДМИН ПАНЕЛЬ =============
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Бронирования столиков
    Route::get('/table-reservations', [AdminController::class, 'tableReservations'])
        ->name('table-reservations');
    Route::put('/table-reservations/{id}/cancel', [AdminController::class, 'cancelTableReservation'])
        ->name('table-reservations.cancel');
    
    // Заказы
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::put('/orders/{id}', [AdminController::class, 'updateOrder'])->name('orders.update');
    
    // Категории
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
    Route::get('/categories/create', [AdminController::class, 'createCategory'])->name('categories.create');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::get('/categories/{id}/edit', [AdminController::class, 'editCategory'])->name('categories.edit');
    Route::put('/categories/{id}', [AdminController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{id}', [AdminController::class, 'deleteCategory'])->name('categories.delete');
    
    // Продукты
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::get('/products/create', [AdminController::class, 'createProduct'])->name('products.create');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('products.store');
    Route::get('/products/{id}/edit', [AdminController::class, 'editProduct'])->name('products.edit');
    Route::put('/products/{id}', [AdminController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{id}', [AdminController::class, 'deleteProduct'])->name('products.delete');
    
    // Галерея
    Route::get('/gallery', [AdminController::class, 'gallery'])->name('gallery');
    Route::post('/gallery', [AdminController::class, 'storeGallery'])->name('gallery.store');
    Route::delete('/gallery/{id}', [AdminController::class, 'deleteGallery'])->name('gallery.delete');
    Route::post('/gallery/order', [AdminController::class, 'updateGalleryOrder'])->name('gallery.order');
});

// ============= ТЕСТОВЫЕ МАРШРУТЫ =============
Route::get('/test-mail', function() {
    try {
        Mail::raw('Тестовое письмо от ресторана', function ($message) {
            $message->to('your-email@example.com')
                    ->subject('Тест почты');
        });
        return 'Письмо отправлено! Проверьте почту.';
    } catch (\Exception $e) {
        return 'Ошибка: ' . $e->getMessage();
    }
});

// Для отладки
Route::get('/api/check-auth', function() {
    return response()->json([
        'authenticated' => Auth::check(),
        'user_id' => Auth::id(),
        'user' => Auth::user()
    ]);
});

Route::get('/api/users', function() {
    $users = \App\Models\User::select('id', 'full_name', 'email', 'phone', 'is_admin', 'created_at')
        ->get();
    
    return response()->json($users);
});

// Для тестирования
if (config('app.debug')) {
    Route::get('/test-registration', function() {
        return view('test-registration');
    });
    
    Route::post('/test-registration', [AuthController::class, 'testRegistration'])->name('test.registration');
}