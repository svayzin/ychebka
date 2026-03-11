<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        // Получаем параметр сортировки
        $sort = $request->get('sort', 'default');
        
        // Получаем все категории с активными продуктами
        $categories = Category::where('active', true)
            ->orderBy('order')
            ->with(['products' => function($query) use ($sort) {
                $query->where('active', true);
                
                // ПРИМЕНЯЕМ СОРТИРОВКУ
                if ($sort === 'price_asc') {
                    $query->orderBy('price', 'asc');
                } elseif ($sort === 'price_desc') {
                    $query->orderBy('price', 'desc');
                } else {
                    $query->orderBy('order');
                }
            }])
            ->get();

        // ДЛЯ ОТЛАДКИ - раскомментируйте чтобы увидеть запросы в логах
        \Log::info('Menu sort applied: ' . $sort);
        
        return view('menu.index', compact('categories'));
    }

    public function category($slug, Request $request)
    {
        // Получаем параметр сортировки
        $sort = $request->get('sort', 'default');
        
        $category = Category::where('slug', $slug)
            ->where('active', true)
            ->with(['products' => function($query) use ($sort) {
                $query->where('active', true);
                
                // ПРИМЕНЯЕМ СОРТИРОВКУ
                if ($sort === 'price_asc') {
                    $query->orderBy('price', 'asc');
                } elseif ($sort === 'price_desc') {
                    $query->orderBy('price', 'desc');
                } else {
                    $query->orderBy('order');
                }
            }])
            ->firstOrFail();

        $categories = Category::where('active', true)
            ->orderBy('order')
            ->get();

        // ДЛЯ ОТЛАДКИ
        \Log::info('Category sort applied: ' . $sort . ' for category: ' . $slug);

        return view('menu.category', compact('category', 'categories'));
    }
}