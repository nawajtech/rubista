<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Exception;

class RazorpayController extends Controller
{
    public function index()
    {
        return view('razorpay.pay');
    }

    public function createOrder(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $key = config('razorpay.key');
        $secret = config('razorpay.secret');
        if (empty($key) || empty($secret)) {
            return response()->json(['error' => 'Razorpay is not configured.'], 500);
        }

        try {
            $api = new Api($key, $secret);
            $amountPaise = (int) round($request->amount * 100);

            $order = $api->order->create([
                'receipt' => 'order_' . time(),
                'amount' => $amountPaise,
                'currency' => 'INR',
            ]);

            return response()->json([
                'order_id' => $order['id'],
                'amount' => $order['amount'],
                'key' => $key,
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Could not create payment order.'], 500);
        }
    }

    public function paymentSuccess(Request $request)
    {
        $api = new Api(
            config('razorpay.key'),
            config('razorpay.secret')
        );

        try {
            $api->utility->verifyPaymentSignature([
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
            ]);

            // ✅ Save payment in DB here
            return "Payment Successful";

        } catch (Exception $e) {
            return "Payment Failed";
        }
    }
}
