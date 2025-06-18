<?php

namespace App\Services\Processors;

use App\Services\PaymentProcessorInterface;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class CardPaymentProcessor implements PaymentProcessorInterface
{
    public function process(Payment $payment): array
    {
        Log::info("Processing card payment for user {$payment->user_id}");

        $response = Http::get("https://example.com/pay", [
            'uid' => $payment->user_id,
            'sum' => $payment->amount
        ]);

        $success = $response->body() === "OK";
        $payment->status = $success ? 'success' : 'failed';
        $payment->save();

        return [
            'success' => $success,
            'message' => $success ? 'Payment successful!' : 'Payment failed!'
        ];
    }
}
