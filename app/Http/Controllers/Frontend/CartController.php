<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Session;

class CartController extends Controller
{
    public function __construct()
    {
        // Allow cart operations for both authenticated and guest users
        // Remove auth middleware to allow guest cart functionality
    }

    /**
     * Display the cart page
     */
    public function index()
    {
        $cart = Session::get('cart', []);
        $cartItems = [];
        $total = 0;
        
        foreach ($cart as $id => $details) {
            $product = Product::find($id);
            if ($product) {
                $cartItems[] = [
                    'id' => $id,
                    'product' => $product,
                    'quantity' => $details['quantity'],
                    'price' => $product->sale_price ?? $product->price,
                    'total' => ($product->sale_price ?? $product->price) * $details['quantity']
                ];
                $total += ($product->sale_price ?? $product->price) * $details['quantity'];
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
        if ($freeShippingThreshold > 0 && $total >= $freeShippingThreshold) {
            $shipping = 0;
        } elseif ($shippingFee > 0) {
            $shipping = $shippingFee;
        }
        
        // Calculate tax
        $taxRate = $settings['tax_rate'] ?? 0;
        $tax = $taxRate > 0 ? ($total * $taxRate / 100) : 0;
        
        $grandTotal = $total + $shipping + $tax;
        
        return view('frontend.cart', compact('cartItems', 'total', 'shipping', 'tax', 'grandTotal', 'settings'));
    }
    
    /**
     * Add product to cart
     */
    public function add(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        }
        
        try {
            $product = Product::findOrFail($request->product_id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found'
                ], 404);
            }
            throw $e;
        }
        
        $cart = Session::get('cart', []);
        
        if (isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] += $request->quantity;
        } else {
            $cart[$request->product_id] = [
                'name' => $product->name,
                'quantity' => $request->quantity,
                'price' => $product->sale_price ?? $product->price,
                'image' => $product->image
            ];
        }
        
        Session::put('cart', $cart);
        
        if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully!',
                'cart_count' => count($cart)
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }
    
    /**
     * Update cart item quantity
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'quantity' => 'required|integer|min:1'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        }
        
        $cart = Session::get('cart', []);
        
        if (!isset($cart[$id])) {
            if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item not found in cart'
                ], 404);
            }
            return redirect()->back()->with('error', 'Item not found in cart');
        }
        
        $cart[$id]['quantity'] = $request->quantity;
        Session::put('cart', $cart);
        
        if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
            $product = Product::find($id);
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found'
                ], 404);
            }
            
            $itemTotal = ($product->sale_price ?? $product->price) * $request->quantity;
            
            // Calculate new total
            $total = 0;
            foreach ($cart as $itemId => $details) {
                $itemProduct = Product::find($itemId);
                if ($itemProduct) {
                    $total += ($itemProduct->sale_price ?? $itemProduct->price) * $details['quantity'];
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
            if ($freeShippingThreshold > 0 && $total >= $freeShippingThreshold) {
                $shipping = 0;
            } elseif ($shippingFee > 0) {
                $shipping = $shippingFee;
            }
            
            // Calculate tax
            $taxRate = $settings['tax_rate'] ?? 0;
            $tax = $taxRate > 0 ? ($total * $taxRate / 100) : 0;
            
            $grandTotal = $total + $shipping + $tax;
            
            return response()->json([
                'success' => true,
                'message' => 'Cart updated successfully!',
                'item_total' => $itemTotal,
                'cart_total' => $total,
                'shipping' => $shipping,
                'tax' => $tax,
                'grand_total' => $grandTotal,
                'free_shipping_threshold' => $freeShippingThreshold,
                'cart_count' => count($cart)
            ]);
        }

        return redirect()->back()->with('success', 'Cart updated successfully!');
    }
    
    /**
     * Remove item from cart
     */
    public function remove($id)
    {
        $cart = Session::get('cart', []);
        
        if (!isset($cart[$id])) {
            if (request()->ajax() || request()->wantsJson() || request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item not found in cart'
                ], 404);
            }
            return redirect()->back()->with('error', 'Item not found in cart');
        }
        
        unset($cart[$id]);
        Session::put('cart', $cart);
        
        if (request()->ajax() || request()->wantsJson() || request()->expectsJson()) {
            // Calculate new total
            $total = 0;
            foreach ($cart as $itemId => $details) {
                $itemProduct = Product::find($itemId);
                if ($itemProduct) {
                    $total += ($itemProduct->sale_price ?? $itemProduct->price) * $details['quantity'];
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
            if ($freeShippingThreshold > 0 && $total >= $freeShippingThreshold) {
                $shipping = 0;
            } elseif ($shippingFee > 0) {
                $shipping = $shippingFee;
            }
            
            // Calculate tax
            $taxRate = $settings['tax_rate'] ?? 0;
            $tax = $taxRate > 0 ? ($total * $taxRate / 100) : 0;
            
            $grandTotal = $total + $shipping + $tax;
            
            return response()->json([
                'success' => true,
                'message' => 'Product removed from cart!',
                'cart_total' => $total,
                'shipping' => $shipping,
                'tax' => $tax,
                'grand_total' => $grandTotal,
                'free_shipping_threshold' => $freeShippingThreshold,
                'cart_count' => count($cart)
            ]);
        }

        return redirect()->back()->with('success', 'Product removed from cart!');
    }
    
    /**
     * Clear entire cart
     */
    public function clear()
    {
        Session::forget('cart');
        
        if (request()->ajax() || request()->wantsJson() || request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cart cleared successfully!',
                'cart_count' => 0
            ]);
        }

        return redirect()->back()->with('success', 'Cart cleared successfully!');
    }
} 