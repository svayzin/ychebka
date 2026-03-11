<?php
// app/Http/Controllers/HomeController.php
namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $gallery = Gallery::where('active', true)
            ->orderBy('order')
            ->limit(6)
            ->get();
            
        // Получаем несколько популярных товаров для главной
        $popularProducts = Product::where('is_popular', true)
            ->where('active', true)
            ->orderBy('order')
            ->limit(7)
            ->get();
            
        return view('home', compact('gallery', 'popularProducts'));
    }
}