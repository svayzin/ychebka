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
                
                if ($sort === 'price_asc') {
                    $query->orderBy('price', 'asc');
                } elseif ($sort === 'price_desc') {
                    $query->orderBy('price', 'desc');
                } else {
                    $query->orderBy('order');
                }
            }])
            ->get();
        
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

        return view('menu.category', compact('category', 'categories'));
    }
}