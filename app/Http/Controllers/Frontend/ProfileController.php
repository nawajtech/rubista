<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Display the user profile page
     */
    public function index()
    {
        $user = Auth::user();
        $orders = $user->orders()->with('orderItems.product')->latest()->take(5)->get();
        $totalOrders = $user->orders()->count();
        
        // Get wishlist count (assuming wishlist is stored in session or database)
        $wishlistCount = 0;
        if (session()->has('wishlist')) {
            $wishlistCount = count(session('wishlist'));
        }
        
        // Get cart count
        $cartCount = 0;
        if (session()->has('cart')) {
            $cartCount = count(session('cart'));
        }
        
        // Get latest order for address info
        $latestOrder = $user->orders()->latest()->first();
        
        return view('frontend.profile', compact('user', 'orders', 'totalOrders', 'wishlistCount', 'cartCount', 'latestOrder'));
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            // Email is not allowed to be changed
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please correct the errors below.');
        }

        // Only update name, email cannot be changed
        $user->update([
            'name' => $request->name,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully!'
            ]);
        }

        return back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Update user password
     */
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please correct the errors below.');
        }

        $user = Auth::user();

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Current password is incorrect.',
                    'errors' => ['current_password' => ['Current password is incorrect.']]
                ], 422);
            }
            return back()
                ->withErrors(['current_password' => 'Current password is incorrect.'])
                ->withInput()
                ->with('error', 'Current password is incorrect.');
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Password changed successfully!'
            ]);
        }

        return back()->with('success', 'Password changed successfully!');
    }

    /**
     * Update user address
     */
    public function updateAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please correct the errors below.');
        }

        // Store address in user's latest order or create a user_addresses table
        // For now, we'll store it in session or you can create a user_addresses migration
        $user = Auth::user();
        
        // You can extend the users table with address fields or create a separate addresses table
        // For now, we'll just return success
        session()->put('user_address', [
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'phone' => $request->phone,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Address updated successfully!'
            ]);
        }

        return back()->with('success', 'Address updated successfully!');
    }
}

