<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Support\Facades\Log;
use App\Events\PaymentProcessed;

class PaymentService
{
    protected $processors = [];

    public function __construct(array $processors = [])
    {
        $this->processors = $processors;
    }

    public function registerProcessor(string $method, PaymentProcessorInterface $processor)
    {
        $this->processors[$method] = $processor;
        return $this;
    }

    public function processPayment(int $userId, float $amount, string $method)
    {
        Log::info("Processing $method payment for $userId");

        $payment = Payment::create([
            'user_id' => $userId,
            'amount' => $amount,
            'method' => $method,
            'status' => 'pending',
        ]);
        $payment->save();

        if (!isset($this->processors[$method])) {
            Log::error("Unknown payment method: $method");
            return [
                'success' => false,
                'message' => 'Unknown payment method'
            ];
        }

        $result = $this->processors[$method]->process($payment);

        event(new PaymentProcessed($payment));

        return $result;
    }
}