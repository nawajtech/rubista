<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Razorpay\Api\Api;

class OrderController extends Controller
{
    /**
     * Display a listing of the user's orders.
     */
    public function index()
    {
        $orders = Auth::user()->orders()->with('orderItems.product')->latest()->paginate(10);
        return view('frontend.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new order (checkout).
     */
    public function create()
    {
        // Require authentication for checkout
        if (!Auth::check()) {
            return redirect()->route('frontend.login')->with('error', 'Please login to proceed with checkout.');
        }
        
        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('frontend.cart')->with('error', 'Your cart is empty!');
        }
        
        $cartItems = [];
        $subtotal = 0;
        
        foreach ($cart as $id => $details) {
            $product = Product::find($id);
            if ($product) {
                $price = $product->sale_price ?? $product->price;
                $total = $price * $details['quantity'];
                
                $cartItems[] = [
                    'id' => $id,
                    'product' => $product,
                    'quantity' => $details['quantity'],
                    'price' => $price,
                    'total' => $total
                ];
                $subtotal += $total;
            }
        }
        
        // Get settings for shipping and tax
        $settings = Cache::remember('site_settings', 3600, function () {
            $settingsFile = storage_path('app/settings.json');
            
            if (file_exists($settingsFile)) {
                return json_decode(file_get_contents($settingsFile), true);
            }

            return [
                'shipping_fee' => 0,
                'free_shipping_threshold' => 0,
                'tax_rate' => 0,
            ];
        });
        
        // Calculate shipping fee
        $shipping = 0;
        $freeShippingThreshold = $settings['free_shipping_threshold'] ?? 0;
        $shippingFee = $settings['shipping_fee'] ?? 0;
        
        // Apply free shipping if threshold is met
        if ($freeShippingThreshold > 0 && $subtotal >= $freeShippingThreshold) {
            $shipping = 0;
        } elseif ($shippingFee > 0) {
            $shipping = $shippingFee;
        }
        
        // Calculate tax
        $taxRate = $settings['tax_rate'] ?? 0;
        $tax = $taxRate > 0 ? ($subtotal * $taxRate / 100) : 0;
        
        $total = $subtotal + $shipping + $tax;
        
        return view('frontend.orders.checkout', compact('cartItems', 'subtotal', 'shipping', 'tax', 'total', 'settings'));
    }

    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'billing_first_name' => 'required|string|max:255',
            'billing_last_name' => 'required|string|max:255',
            'billing_email' => 'required|email|max:255',
            'billing_phone' => 'required|string|max:20',
            'billing_address' => 'required|string',
            'billing_city' => 'required|string|max:255',
            'billing_state' => 'required|string|max:255',
            'billing_postal_code' => 'required|string|max:20',
            'billing_country' => 'required|string|max:255',
            'shipping_first_name' => 'required|string|max:255',
            'shipping_last_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string|max:255',
            'shipping_state' => 'required|string|max:255',
            'shipping_postal_code' => 'required|string|max:20',
            'shipping_country' => 'required|string|max:255',
            'payment_method' => 'required|in:cod,card,upi,razorpay',
            'notes' => 'nullable|string',
            'razorpay_order_id' => 'required_if:payment_method,razorpay|nullable|string',
            'razorpay_payment_id' => 'required_if:payment_method,razorpay|nullable|string',
            'razorpay_signature' => 'required_if:payment_method,razorpay|nullable|string',
        ]);

        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('frontend.cart')->with('error', 'Your cart is empty!');
        }

        DB::beginTransaction();

        try {
            // Calculate totals
            $subtotal = 0;
            $orderItems = [];
            
            foreach ($cart as $id => $details) {
                $product = Product::find($id);
                if ($product) {
                    $price = $product->sale_price ?? $product->price;
                    $total = $price * $details['quantity'];
                    
                    $subtotal += $total;
                    
                    $orderItems[] = [
                        'product_id' => $id,
                        'product_name' => $product->name,
                        'product_sku' => $product->sku,
                        'product_image' => $product->image,
                        'quantity' => $details['quantity'],
                        'unit_price' => $price,
                        'total_price' => $total,
                    ];
                }
            }
            
            // Get settings for shipping and tax
            $settings = Cache::remember('site_settings', 3600, function () {
                $settingsFile = storage_path('app/settings.json');
                
                if (file_exists($settingsFile)) {
                    return json_decode(file_get_contents($settingsFile), true);
                }

                return [
                    'shipping_fee' => 0,
                    'free_shipping_threshold' => 0,
                    'tax_rate' => 0,
                ];
            });
            
            // Calculate shipping fee
            $shipping = 0;
            $freeShippingThreshold = $settings['free_shipping_threshold'] ?? 0;
            $shippingFee = $settings['shipping_fee'] ?? 0;
            
            // Apply free shipping if threshold is met
            if ($freeShippingThreshold > 0 && $subtotal >= $freeShippingThreshold) {
                $shipping = 0;
            } elseif ($shippingFee > 0) {
                $shipping = $shippingFee;
            }
            
            // Calculate tax
            $taxRate = $settings['tax_rate'] ?? 0;
            $tax = $taxRate > 0 ? ($subtotal * $taxRate / 100) : 0;
            
            $total = $subtotal + $shipping + $tax;

            // Verify Razorpay payment if applicable
            $paymentStatus = $request->payment_method === 'cod' ? 'pending' : 'paid';
            $transactionId = null;
            if ($request->payment_method === 'razorpay') {
                try {
                    $api = new Api(config('razorpay.key'), config('razorpay.secret'));
                    $api->utility->verifyPaymentSignature([
                        'razorpay_order_id' => $request->razorpay_order_id,
                        'razorpay_payment_id' => $request->razorpay_payment_id,
                        'razorpay_signature' => $request->razorpay_signature,
                    ]);
                    $transactionId = $request->razorpay_payment_id;
                } catch (\Exception $e) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Payment verification failed. Please try again.');
                }
            }
            
            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'subtotal' => $subtotal,
                'tax_amount' => $tax,
                'shipping_amount' => $shipping,
                'total_amount' => $total,
                'payment_method' => $request->payment_method,
                'payment_status' => $paymentStatus,
                'transaction_id' => $transactionId,
                'billing_first_name' => $request->billing_first_name,
                'billing_last_name' => $request->billing_last_name,
                'billing_email' => $request->billing_email,
                'billing_phone' => $request->billing_phone,
                'billing_address' => $request->billing_address,
                'billing_city' => $request->billing_city,
                'billing_state' => $request->billing_state,
                'billing_postal_code' => $request->billing_postal_code,
                'billing_country' => $request->billing_country,
                'shipping_first_name' => $request->shipping_first_name,
                'shipping_last_name' => $request->shipping_last_name,
                'shipping_phone' => $request->shipping_phone,
                'shipping_address' => $request->shipping_address,
                'shipping_city' => $request->shipping_city,
                'shipping_state' => $request->shipping_state,
                'shipping_postal_code' => $request->shipping_postal_code,
                'shipping_country' => $request->shipping_country,
                'notes' => $request->notes,
            ]);

            // Create order items
            foreach ($orderItems as $item) {
                $order->orderItems()->create($item);
            }

            DB::commit();

            // Send SMS notification for order confirmation
            try {
                $phone = $request->billing_phone;
                // Remove any non-numeric characters and extract last 10 digits
                $phone = preg_replace('/[^0-9]/', '', $phone);
                $phone = substr($phone, -10);
                
                if (strlen($phone) === 10) {
                    SmsService::sendOrderConfirmation($phone, $order->order_number, $order->total_amount);
                }
            } catch (\Exception $e) {
                // Log error but don't fail the order
                \Log::error('Failed to send order confirmation SMS', [
                    'order_id' => $order->id,
                    'error' => $e->getMessage()
                ]);
            }

            // Clear cart
            Session::forget('cart');

            return redirect()->route('frontend.orders.show', $order)->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        // Make sure user can only view their own orders
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('orderItems.product');
        return view('frontend.orders.show', compact('order'));
    }

    /**
     * Cancel an order
     */
    public function cancel(Order $order)
    {
        // Make sure user can only cancel their own orders
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if (!$order->canBeCancelled()) {
            return redirect()->back()->with('error', 'This order cannot be cancelled.');
        }

        $order->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', 'Order cancelled successfully.');
    }

    /**
     * Generate and display invoice/bill for an order
     */
    public function invoice(Order $order)
    {
        // Make sure user can only view their own orders
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('orderItems', 'user');
        
        // Get site settings for company info
        $settings = Cache::remember('site_settings', 3600, function () {
            $settingsFile = storage_path('app/settings.json');
            if (file_exists($settingsFile)) {
                return json_decode(file_get_contents($settingsFile), true);
            }
            return [];
        });

        return view('frontend.orders.invoice', compact('order', 'settings'));
    }

    /**
     * Download invoice as PDF
     */
    public function downloadInvoice(Order $order)
    {
        // Make sure user can only download their own orders
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('orderItems', 'user');
        
        // Get site settings for company info
        $settings = Cache::remember('site_settings', 3600, function () {
            $settingsFile = storage_path('app/settings.json');
            if (file_exists($settingsFile)) {
                return json_decode(file_get_contents($settingsFile), true);
            }
            return [];
        });

        // For now, return the invoice view (you can use a PDF library like dompdf or snappy later)
        return view('frontend.orders.invoice', compact('order', 'settings'));
    }
}
