<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\PaymentService;
use App\Services\Processors\CardPaymentProcessor;
use App\Services\Processors\CryptoPaymentProcessor;

class PaymentServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(PaymentService::class, function ($app) {
            $service = new PaymentService();
            $service->registerProcessor('card', new CardPaymentProcessor());
            $service->registerProcessor('crypto', new CryptoPaymentProcessor());
            return $service;
        });
    }
}
