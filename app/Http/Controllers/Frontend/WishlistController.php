<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Session;

class WishlistController extends Controller
{
    public function __construct()
    {
        // Allow wishlist for all users, but check auth in methods that need it
    }

    /**
     * Display the wishlist page
     */
    public function index()
    {
        $wishlist = Session::get('wishlist', []);
        $wishlistItems = [];
        
        foreach ($wishlist as $id => $details) {
            $product = Product::find($id);
            if ($product) {
                $wishlistItems[] = [
                    'id' => $id,
                    'product' => $product,
                    'added_at' => $details['added_at']
                ];
            }
        }
        
        return view('frontend.wishlist', compact('wishlistItems'));
    }
    
    /**
     * Add product to wishlist
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $product = Product::findOrFail($request->product_id);
        $wishlist = Session::get('wishlist', []);
        
        if (isset($wishlist[$request->product_id])) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product is already in your wishlist!'
                ]);
            }
            return redirect()->back()->with('error', 'Product is already in your wishlist!');
        }

        $wishlist[$request->product_id] = [
            'name' => $product->name,
            'price' => $product->sale_price ?? $product->price,
            'image' => $product->image,
            'added_at' => now()
        ];

        Session::put('wishlist', $wishlist);
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to wishlist successfully!',
                'wishlist_count' => count($wishlist)
            ]);
        }

        return redirect()->back()->with('success', 'Product added to wishlist successfully!');
    }
    
    /**
     * Remove item from wishlist
     */
    public function remove($id)
    {
        $wishlist = Session::get('wishlist', []);
        
        if (isset($wishlist[$id])) {
            unset($wishlist[$id]);
            Session::put('wishlist', $wishlist);
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product removed from wishlist!',
                    'wishlist_count' => count($wishlist)
                ]);
            }
        }

        return redirect()->back()->with('success', 'Product removed from wishlist!');
    }
    
    /**
     * Move item from wishlist to cart
     */
    public function moveToCart($id)
    {
        $wishlist = Session::get('wishlist', []);
        $cart = Session::get('cart', []);
        
        if (isset($wishlist[$id])) {
            $product = Product::find($id);
            if ($product) {
                // Add to cart
                if (isset($cart[$id])) {
                    $cart[$id]['quantity'] += 1;
                } else {
                    $cart[$id] = [
                        'name' => $product->name,
                        'quantity' => 1,
                        'price' => $product->sale_price ?? $product->price,
                        'image' => $product->image
                    ];
                }
                
                // Remove from wishlist
                unset($wishlist[$id]);
                
                Session::put('cart', $cart);
                Session::put('wishlist', $wishlist);
                
                if (request()->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Product moved to cart successfully!',
                        'cart_count' => count($cart),
                        'wishlist_count' => count($wishlist)
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Product moved to cart successfully!');
    }

    public function clear()
    {
        Session::forget('wishlist');
        
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Wishlist cleared successfully!',
                'wishlist_count' => 0
            ]);
        }

        return redirect()->back()->with('success', 'Wishlist cleared successfully!');
    }

    /**
     * Toggle product in wishlist (add if not present, remove if present)
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $product = Product::findOrFail($request->product_id);
        $wishlist = Session::get('wishlist', []);
        $productId = $request->product_id;
        
        $wasInWishlist = isset($wishlist[$productId]);
        
        if ($wasInWishlist) {
            // Remove from wishlist
            unset($wishlist[$productId]);
            $message = 'Product removed from wishlist!';
            $action = 'removed';
        } else {
            // Add to wishlist
            $wishlist[$productId] = [
                'name' => $product->name,
                'price' => $product->sale_price ?? $product->price,
                'image' => $product->image,
                'added_at' => now()
            ];
            $message = 'Product added to wishlist successfully!';
            $action = 'added';
        }

        Session::put('wishlist', $wishlist);
        
        if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'action' => $action,
                'in_wishlist' => !$wasInWishlist,
                'wishlist_count' => count($wishlist)
            ]);
        }

        return redirect()->back()->with('success', $message);
    }
} 