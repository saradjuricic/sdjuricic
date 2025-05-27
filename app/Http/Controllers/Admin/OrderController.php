<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index()
    {
        $orders = Order::with(['user', 'orderItems.product.category'])
                      ->orderBy('created_at', 'desc')
                      ->get();
        
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.product.category']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update the order status.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        $message = "Order #{$order->id} status updated to " . ucfirst($request->status);
        
        return redirect()->back()->with('success', $message);
    }
}