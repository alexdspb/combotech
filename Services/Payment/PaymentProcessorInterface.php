<?php

namespace App\Services;

use App\Models\Payment;

interface PaymentProcessorInterface
{
    public function process(Payment $payment): array;
}
