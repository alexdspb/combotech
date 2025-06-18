<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Events\PaymentProcessed;
use App\Models\Payment;
use App\Services\PaymentService;

class PaymentController
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function pay(Request $request)
    {
        $request->validate([
            'uid' => 'required|integer',
            'sum' => 'required|numeric|min:0.01',
            'method' => 'required|string',
        ]);

        $result = $this->paymentService->processPayment(
            $request->input('uid'),
            $request->input('sum'),
            $request->input('method')
        );

        return response()->json($result);
    }
}

