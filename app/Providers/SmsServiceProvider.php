<?php
// app/Providers/SmsServiceProvider.php

namespace App\Providers;

use App\Services\SmsService;
use Illuminate\Support\ServiceProvider;

class SmsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(SmsService::class, function ($app) {
            return new SmsService();
        });
    }
}