<?php
// app/Http/Controllers/AdminController.php
namespace App\Http\Controllers;

use App\Models\TableReservation;
use App\Models\User;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Auth::user() || !Auth::user()->is_admin) {
                abort(403, 'Доступ запрещен');
            }
            return $next($request);
        });
    }

    // ================ DASHBOARD ================
    public function dashboard()
    {
        // последние брони столиков
        $reservations = TableReservation::with('table')
            ->orderBy('start_at', 'desc')
            ->take(10)
            ->get();
            // статистика по бронированию столиков
        $stats = [
            // общее количество броней столиков
            'total_reservations' => TableReservation::count(),
            // брони на сегодня (по дате начала)
            'today_reservations' => TableReservation::whereDate('start_at', today())->count(),
            // "ожидают" = активные, не отменённые, ещё не закончились
            'pending_reservations' => TableReservation::where('cancelled', false)
                ->where('end_at', '>', now())
                ->count(),
            // остальное как было
            'total_users' => User::count(),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
    ];
    return view('admin.dashboard', compact('reservations', 'stats'));
    }

    // ================ БРОНИРОВАНИЯ СТОЛИКОВ ================
    public function tableReservations(Request $request)
        {
            $query = TableReservation::with(['table', 'user'])->orderBy('start_at', 'desc');

            if ($request->filled('only_active')) {
                $query->where('cancelled', false)
                    ->where('end_at', '>', now());
            }

            $reservations = $query->paginate(20);

            return view('admin.table-reservations.index', compact('reservations'));
        }

        public function cancelTableReservation($id)
        {
            $reservation = TableReservation::findOrFail($id);
            $reservation->cancelled = true;
            $reservation->save();

            return redirect()->route('admin.table-reservations')
                ->with('success', "Бронь столика #{$reservation->id} помечена как отменённая.");
    }

    // ================ ЗАКАЗЫ ================
    public function orders()
    {
        $query = Order::with('user', 'items.product')
            ->orderBy('created_at', 'desc');

        if (request()->filled('status')) {
            $query->where('status', request('status'));
        }

        $orders = $query->paginate(20)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function updateOrder(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);
        
        $order->update(['status' => $request->status]);
        
        return back()->with('success', 'Статус заказа обновлен');
    }

    // ================ КАТЕГОРИИ ================
    public function categories()
    {
        $categories = Category::orderBy('order')->paginate(20);
        return view('admin.categories.index', compact('categories'));
    }

    public function createCategory()
    {
        return view('admin.categories.create');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);
        
        try {
            $category = Category::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'description' => $request->description,
                'order' => $request->order ?? 0,
                'active' => $request->has('active'),
            ]);
            
            return redirect()->route('admin.categories')
                ->with('success', 'Категория "' . $category->name . '" успешно создана!');
                
        } catch (\Exception $e) {
            \Log::error('Category creation error: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Ошибка при создании категории: ' . $e->getMessage());
        }
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $id,
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);
        
        $category->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'order' => $request->order ?? $category->order,
            'active' => $request->has('active'),
        ]);
        
        return redirect()->route('admin.categories')
            ->with('success', 'Категория обновлена');
    }

    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);
        
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Нельзя удалить категорию с товарами');
        }
        
        $category->delete();
        
        return back()->with('success', 'Категория удалена');
    }

    // ================ ПРОДУКТЫ (БЛЮДА) ================
    public function products(Request $request)
    {
        $query = Product::with('category')->orderBy('order');
        
        if ($request->category) {
            $query->where('category_id', $request->category);
        }
        
        if ($request->status == 'active') {
            $query->where('active', true);
        } elseif ($request->status == 'inactive') {
            $query->where('active', false);
        }
        
        if ($request->search) {
            $search = mb_strtolower(trim($request->search));
            $query->where(function($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(description) LIKE ?', ["%{$search}%"]);
            });
        }
        
        $products = $query->paginate(20);
        $categories = Category::where('active', true)->get();
        
        return view('admin.products.index', compact('products', 'categories'));
    }

    public function createProduct()
    {
        $categories = Category::where('active', true)->get();
        return view('admin.products.create', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'weight' => 'required|integer|min:1',
            'weight_unit' => 'required|string|max:10',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'order' => 'nullable|integer',
        ]);
        
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'weight' => $request->weight,
            'weight_unit' => $request->weight_unit,
            'category_id' => $request->category_id,
            'order' => $request->order ?? 0,
            'active' => $request->has('active'),
            'is_new' => $request->has('is_new'),
            'is_popular' => $request->has('is_popular'),
        ];
        
        if ($request->hasFile('image')) {
            try {
                $data['image'] = $this->storeProductImage($request->file('image'));
            } catch (\Exception $e) {
                \Log::error('Image upload error: ' . $e->getMessage());
                return back()->withInput()->with('error', 'Ошибка загрузки изображения');
            }
        }
        
        try {
            $product = Product::create($data);
            
            return redirect()->route('admin.products')
                ->with('success', 'Блюдо "' . $product->name . '" успешно создано!');
                
        } catch (\Exception $e) {
            \Log::error('Product creation error: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Ошибка при создании блюда: ' . $e->getMessage());
        }
    }

    public function editProduct($id)
    {
        try {
            $product = Product::with('category')->findOrFail($id);
            $categories = Category::where('active', true)->get();
            
            return view('admin.products.edit', compact('product', 'categories'));
        } catch (\Exception $e) {
            \Log::error('Edit product error: ' . $e->getMessage());
            return redirect()->route('admin.products')
                ->with('error', 'Блюдо не найдено');
        }
    }

    public function updateProduct(Request $request, $id)
{
    try {
        $product = Product::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'weight' => 'required|integer|min:1',
            'weight_unit' => 'required|string|max:10',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'order' => 'nullable|integer',
            'remove_image' => 'nullable|boolean',
        ]);
        
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'weight' => $request->weight,
            'weight_unit' => $request->weight_unit,
            'category_id' => $request->category_id,
            'order' => $request->order ?? $product->order,
            'active' => $request->has('active'),
            'is_new' => $request->has('is_new'),
            'is_popular' => $request->has('is_popular'),
        ];
        
        // 1. ЕСЛИ ПОСТАВЛЕНА ГАЛОЧКА "УДАЛИТЬ ФОТО"
        if ($request->has('remove_image') && $request->remove_image == 1) {
            if ($product->image) {
                $this->deleteProductImage($product->image);
            }
            $data['image'] = null;
        }
        
        // 2. ЕСЛИ ЗАГРУЖЕНО НОВОЕ ФОТО
        if ($request->hasFile('image')) {
            if ($product->image) {
                $this->deleteProductImage($product->image);
            }
            $data['image'] = $this->storeProductImage($request->file('image'));
        }
        
        $product->update($data);
        
        \Log::info('Product updated successfully', ['id' => $product->id]);
        
        return redirect()->route('admin.products')
            ->with('success', 'Блюдо "' . $product->name . '" успешно обновлено!');
            
    } catch (\Exception $e) {
        \Log::error('Update product error: ' . $e->getMessage());
        return back()
            ->withInput()
            ->with('error', 'Ошибка при обновлении блюда: ' . $e->getMessage());
    }
}

    public function deleteProduct($id)
    {
        try {
            $product = Product::findOrFail($id);
            
            if ($product->image) {
                $this->deleteProductImage($product->image);
            }
            
            $product->delete();
            
            return back()->with('success', 'Блюдо "' . $product->name . '" удалено');
        } catch (\Exception $e) {
            \Log::error('Delete product error: ' . $e->getMessage());
            return back()->with('error', 'Ошибка при удалении блюда');
        }
    }

    /** Сохранить фото блюда в public/images/products (работает без симлинка storage) */
    private function storeProductImage($file): string
    {
        $dir = public_path('images/products');
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $ext = $file->getClientOriginalExtension() ?: 'jpg';
        $name = uniqid('', true) . '.' . $ext;
        $file->move($dir, $name);
        return 'images/products/' . $name;
    }

    /** Удалить файл фото (поддержка storage и public) */
    private function deleteProductImage(string $path): void
    {
        if (str_starts_with($path, 'images/')) {
            $fullPath = public_path($path);
            if (is_file($fullPath)) {
                unlink($fullPath);
            }
            return;
        }
        Storage::disk('public')->delete($path);
    }
}