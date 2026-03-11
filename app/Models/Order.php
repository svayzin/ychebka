<?php
// app/Models/Order.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total',
        'address',
        'notes',
        'delivery_type',
        'payment_method',
        'status',
        'city',
        'street',
        'house',
        'apartment',
        'entrance',
        'floor',
        'intercom'
    ];

    protected $casts = [
        'total' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getFormattedTotalAttribute()
    {
        return number_format($this->total, 0, '.', ' ') . ' ₽';
    }

    public function getStatusTextAttribute()
    {
        $statuses = [
            'pending' => 'Ожидание',
            'accepted' => 'Принят',
            'preparing' => 'Готовится',
            'delivering' => 'В пути',
            'completed' => 'Завершен',
            'cancelled' => 'Отменен'
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            'pending' => 'warning',
            'accepted' => 'info',
            'preparing' => 'primary',
            'delivering' => 'warning',
            'completed' => 'success',
            'cancelled' => 'danger'
        ];

        return $colors[$this->status] ?? 'secondary';
    }

    public function getDeliveryTypeTextAttribute()
    {
        $types = [
            'delivery' => 'Доставка',
            'pickup' => 'Самовывоз'
        ];

        return $types[$this->delivery_type] ?? $this->delivery_type;
    }

    public function getPaymentMethodTextAttribute()
    {
        $methods = [
            'card' => 'Банковская карта',
            'online' => 'Онлайн-оплата',
            'cash' => 'Наличные'
        ];

        return $methods[$this->payment_method] ?? $this->payment_method;
    }

    public function getFullAddressAttribute()
    {
        if ($this->delivery_type === 'pickup') {
            return $this->address;
        }

        $parts = [];
        if ($this->city) $parts[] = $this->city;
        if ($this->street) $parts[] = 'ул. ' . $this->street;
        if ($this->house) $parts[] = 'д. ' . $this->house;
        if ($this->apartment) $parts[] = 'кв. ' . $this->apartment;
        if ($this->entrance) $parts[] = 'под. ' . $this->entrance;
        if ($this->floor) $parts[] = 'эт. ' . $this->floor;
        if ($this->intercom) $parts[] = 'домофон: ' . $this->intercom;

        return implode(', ', $parts);
    }
}