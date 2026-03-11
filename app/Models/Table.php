<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Table extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'seats_min',
        'seats_max',
        'deposit_per_person',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function reservations()
    {
        return $this->hasMany(TableReservation::class);
    }
}