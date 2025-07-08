<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Display a listing of the customers.
     */
    public function index(Request $request)
    {
        $query = User::where('is_admin', false);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $customers = $query->withCount('orders')->latest()->paginate(10);

        $totalCustomers = User::where('is_admin', false)->count();
        $activeCustomers = User::where('is_admin', false)->whereHas('orders')->count();
        $newCustomers = User::where('is_admin', false)->where('created_at', '>=', now()->subDays(30))->count();

        return view('admin.customers.index', compact('customers', 'totalCustomers', 'activeCustomers', 'newCustomers'));
    }

    /**
     * Show the form for creating a new customer.
     */
    public function create()
    {
        return view('admin.customers.create');
    }

    /**
     * Store a newly created customer in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => false,
        ]);

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer created successfully.');
    }

    /**
     * Display the specified customer.
     */
    public function show(User $customer)
    {
        $customer->loadCount('orders');
        $recentOrders = $customer->orders()->with('orderItems')->latest()->take(5)->get();
        $totalSpent = $customer->orders()->where('payment_status', 'paid')->sum('total_amount');
        
        return view('admin.customers.show', compact('customer', 'recentOrders', 'totalSpent'));
    }

    /**
     * Show the form for editing the specified customer.
     */
    public function edit(User $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update the specified customer in storage.
     */
    public function update(Request $request, User $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $customer->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $customer->update($data);

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified customer from storage.
     */
    public function destroy(User $customer)
    {
        // Check if customer has orders
        if ($customer->orders()->count() > 0) {
            return redirect()->route('admin.customers.index')
                ->with('error', 'Cannot delete customer with existing orders.');
        }

        $customer->delete();

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer deleted successfully.');
    }
}
