<?php
// app/Models/Product.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'weight',
        'weight_unit',
        'price',
        'image',
        'category_id',
        'is_new',
        'is_popular',
        'order',
        'active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_new' => 'boolean',
        'is_popular' => 'boolean',
        'active' => 'boolean'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 0, '.', ' ') . ' ₽';
    }

    public function getWeightDisplayAttribute()
    {
        return $this->weight . ' ' . $this->weight_unit;
    }
}