<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Session;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
        
        return view('frontend.cart', compact('cartItems', 'total'));
    }
    
    /**
     * Add product to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);
        
        $product = Product::findOrFail($request->product_id);
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
        
        if ($request->ajax()) {
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
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);
        
        $cart = Session::get('cart', []);
        
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            Session::put('cart', $cart);
            
            if ($request->ajax()) {
                $product = Product::find($id);
                $itemTotal = ($product->sale_price ?? $product->price) * $request->quantity;
                
                // Calculate new total
                $total = 0;
                foreach ($cart as $itemId => $details) {
                    $itemProduct = Product::find($itemId);
                    if ($itemProduct) {
                        $total += ($itemProduct->sale_price ?? $itemProduct->price) * $details['quantity'];
                    }
                }
                
                return response()->json([
                    'success' => true,
                    'message' => 'Cart updated successfully!',
                    'item_total' => $itemTotal,
                    'cart_total' => $total,
                    'cart_count' => count($cart)
                ]);
            }
        }

        return redirect()->back()->with('success', 'Cart updated successfully!');
    }
    
    /**
     * Remove item from cart
     */
    public function remove($id)
    {
        $cart = Session::get('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
            
            if (request()->ajax()) {
                // Calculate new total
                $total = 0;
                foreach ($cart as $itemId => $details) {
                    $itemProduct = Product::find($itemId);
                    if ($itemProduct) {
                        $total += ($itemProduct->sale_price ?? $itemProduct->price) * $details['quantity'];
                    }
                }
                
                return response()->json([
                    'success' => true,
                    'message' => 'Product removed from cart!',
                    'cart_total' => $total,
                    'cart_count' => count($cart)
                ]);
            }
        }

        return redirect()->back()->with('success', 'Product removed from cart!');
    }
    
    /**
     * Clear entire cart
     */
    public function clear()
    {
        Session::forget('cart');
        
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Cart cleared successfully!',
                'cart_count' => 0
            ]);
        }

        return redirect()->back()->with('success', 'Cart cleared successfully!');
    }
} 