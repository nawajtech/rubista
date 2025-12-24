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
        $api = new Api(
            config('razorpay.key'),
            config('razorpay.secret')
        );

        $order = $api->order->create([
            'receipt' => 'order_' . time(),
            'amount' => $request->amount * 100, // in paise
            'currency' => 'INR'
        ]);

        return response()->json([
            'order_id' => $order['id'],
            'amount' => $order['amount'],
            'key' => config('razorpay.key')
        ]);
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
