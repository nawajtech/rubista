<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'orderItems']);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('order_number', 'like', '%' . $request->search . '%')
                  ->orWhere('billing_email', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function ($userQuery) use ($request) {
                      $userQuery->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->has('payment_status') && $request->payment_status) {
            $query->where('payment_status', $request->payment_status);
        }

        $orders = $query->latest()->paginate(10);

        // Statistics
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $shippedOrders = Order::where('status', 'shipped')->count();
        $deliveredOrders = Order::where('status', 'delivered')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total_amount');

        return view('admin.orders.index', compact(
            'orders',
            'totalOrders',
            'pendingOrders',
            'processingOrders',
            'shippedOrders',
            'deliveredOrders',
            'cancelledOrders',
            'totalRevenue'
        ));
    }

    /**
     * Show the form for creating a new order.
     */
    public function create()
    {
        $customers = User::where('is_admin', false)->get();
        return view('admin.orders.create', compact('customers'));
    }

    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request)
    {
        // This would be complex - typically orders are created through checkout
        // For now, redirect to index
        return redirect()->route('admin.orders.index')
            ->with('info', 'Orders are typically created through the checkout process.');
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.product']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified order.
     */
    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    /**
     * Update the specified order in storage.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
            'tracking_number' => 'nullable|string|max:255',
            'admin_notes' => 'nullable|string',
        ]);

        $data = $request->only(['status', 'payment_status', 'tracking_number', 'admin_notes']);

        // Set shipped_at when status changes to shipped
        if ($request->status === 'shipped' && $order->status !== 'shipped') {
            $data['shipped_at'] = now();
        }

        // Set delivered_at when status changes to delivered
        if ($request->status === 'delivered' && $order->status !== 'delivered') {
            $data['delivered_at'] = now();
        }

        $order->update($data);

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order updated successfully.');
    }

    /**
     * Remove the specified order from storage.
     */
    public function destroy(Order $order)
    {
        // Only allow deletion of cancelled orders
        if ($order->status !== 'cancelled') {
            return redirect()->route('admin.orders.index')
                ->with('error', 'Only cancelled orders can be deleted.');
        }

        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order deleted successfully.');
    }

    /**
     * Update order status quickly
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $data = ['status' => $request->status];

        // Set timestamps for status changes
        if ($request->status === 'shipped' && $order->status !== 'shipped') {
            $data['shipped_at'] = now();
        }

        if ($request->status === 'delivered' && $order->status !== 'delivered') {
            $data['delivered_at'] = now();
        }

        $order->update($data);

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }
}
