<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $totalCategories = Category::count();
        $totalProducts = Product::count();
        $activeProducts = Product::where('status', true)->count();
        $inactiveProducts = Product::where('status', false)->count();
        $featuredProducts = Product::where('featured', true)->count();
        $recentProducts = Product::with('category')->latest()->take(5)->get();
        
        // Order statistics
        $totalOrders = Order::count();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total_amount');
        $totalCustomers = User::where('is_admin', false)->count();

        return view('admin.dashboard', compact(
            'totalCategories',
            'totalProducts', 
            'activeProducts',
            'inactiveProducts',
            'featuredProducts',
            'recentProducts',
            'totalOrders',
            'totalRevenue',
            'totalCustomers'
        ));
    }
}
