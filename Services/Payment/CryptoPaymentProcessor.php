<?php

namespace App\Services\Processors;

use App\Services\PaymentProcessorInterface;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;

class CryptoPaymentProcessor implements PaymentProcessorInterface
{
    public function process(Payment $payment): array
    {
        Log::info("Processing crypto payment for user {$payment->user_id}");

        $payment->status = 'processing';
        $payment->save();

        return [
            'success' => true,
            'message' => 'Wait for confirmation...'
        ];
    }
}
