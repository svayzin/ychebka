<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'password',
        'is_admin',
        'two_factor_enabled',
        'two_factor_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'two_factor_enabled' => 'boolean',
            'two_factor_verified_at' => 'datetime',
        ];
    }

    /**
     * Get the cart items for the user.
     */
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Get the orders for the user.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the reservations for the user.
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Get the two factor codes for the user.
     */
    public function twoFactorCodes()
    {
        return $this->hasMany(TwoFactorCode::class);
    }

    /**
     * Generate a new two factor code.
     *
     * @return \App\Models\TwoFactorCode
     */
    public function generateTwoFactorCode()
    {
        // Удаляем старые неиспользованные коды
        $this->twoFactorCodes()
            ->where('used', false)
            ->where('expires_at', '<', now())
            ->delete();
        
        // Генерируем 6-значный код
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Сохраняем код
        return $this->twoFactorCodes()->create([
            'code' => $code,
            'expires_at' => now()->addMinutes(10),
            'used' => false
        ]);
    }

    /**
     * Verify the two factor code.
     *
     * @param string $code
     * @return bool
     */
    public function verifyTwoFactorCode($code)
    {
        $twoFactorCode = $this->twoFactorCodes()
            ->where('code', $code)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->first();

        if ($twoFactorCode) {
            $twoFactorCode->update(['used' => true]);
            $this->update(['two_factor_verified_at' => now()]);
            return true;
        }

        return false;
    }

    /**
     * Check if user has valid two factor session.
     *
     * @return bool
     */
    public function hasValidTwoFactorSession()
    {
        return $this->two_factor_verified_at && 
               $this->two_factor_verified_at->diffInMinutes(now()) < 30;
    }

    /**
     * Reset two factor verification.
     *
     * @return void
     */
    public function resetTwoFactorVerification()
    {
        $this->update(['two_factor_verified_at' => null]);
    }

    /**
     * Check if user is admin.
     *
     * @return bool
     */
    public function getIsAdminAttribute()
    {
        return $this->attributes['is_admin'] ?? false;
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->attributes['full_name'] ?? '';
    }

    /**
     * Get masked phone number for display.
     *
     * @return string|null
     */
    public function getMaskedPhoneAttribute()
    {
        if (!$this->phone) {
            return null;
        }

        $phone = preg_replace('/[^\d+]/', '', $this->phone);
        
        if (strlen($phone) >= 10) {
            return substr($phone, 0, 4) . '******' . substr($phone, -2);
        }
        
        return $this->phone;
    }

    /**
     * Check if user has phone number.
     *
     * @return bool
     */
    public function hasPhone()
    {
        return !empty($this->phone);
    }

    /**
     * Enable two factor authentication.
     *
     * @return void
     */
    public function enableTwoFactor()
    {
        $this->update(['two_factor_enabled' => true]);
    }

    /**
     * Disable two factor authentication.
     *
     * @return void
     */
    public function disableTwoFactor()
    {
        $this->update(['two_factor_enabled' => false]);
        $this->resetTwoFactorVerification();
        
        // Delete all unused codes
        $this->twoFactorCodes()->delete();
    }

    public function tableReservations()
{
    return $this->hasMany(\App\Models\TableReservation::class);
}
}