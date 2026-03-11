<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'date',
        'time',
        'guests',
        'user_id',
        'confirmed',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'confirmed' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Вспомогательные методы
    public function getFormattedDateAttribute()
    {
        return $this->date->format('d.m.Y');
    }

    public function getDateTimeAttribute()
    {
        return $this->date->format('d.m.Y') . ' ' . $this->time;
    }

    public function getStatusTextAttribute()
    {
        return $this->confirmed ? 'Подтверждена' : 'Ожидает подтверждения';
    }

    public function getStatusColorAttribute()
    {
        return $this->confirmed ? 'success' : 'warning';
    }
}