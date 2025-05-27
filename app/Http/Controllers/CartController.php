<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stock
        ]);

        // Get or create cart from session
        $cart = session()->get('cart', []);
        
        $productId = $product->id;
        $quantity = $request->quantity;

        // If product already in cart, update quantity
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            // Add new product to cart
            $cart[$productId] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'image' => $product->image
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function viewCart()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart.index', compact('cart', 'total'));
    }

    public function updateCart(Request $request)
    {
        $cart = session()->get('cart', []);
        
        foreach ($request->quantities as $productId => $quantity) {
            if ($quantity > 0) {
                $cart[$productId]['quantity'] = $quantity;
            } else {
                unset($cart[$productId]);
            }
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
    }

    public function removeFromCart($productId)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Product removed from cart!');
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart.checkout', compact('cart', 'total'));
    }

    public function placeOrder(Request $request)
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        // Calculate total
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Create order
        $order = Order::create([
            'user_id' => Auth::id(),
            'total' => $total,
            'status' => 'pending'
        ]);

        // Create order items
        foreach ($cart as $productId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);

            // Reduce product stock
            $product = Product::find($productId);
            if ($product) {
                $product->decrement('stock', $item['quantity']);
            }
        }

        // Clear cart
        session()->forget('cart');

        return redirect()->route('order.success', $order)->with('success', 'Order placed successfully!');
    }

    public function buyNow(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stock
        ]);

        $quantity = $request->quantity;
        $total = $product->price * $quantity;

        // Create order directly
        $order = Order::create([
            'user_id' => Auth::id(),
            'total' => $total,
            'status' => 'pending'
        ]);

        // Create order item
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $quantity,
            'price' => $product->price
        ]);

        // Reduce product stock
        $product->decrement('stock', $quantity);

        return redirect()->route('order.success', $order)->with('success', 'Order placed successfully!');
    }

    public function orderSuccess(Order $order)
    {
        // Make sure user can only see their own orders
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('orderItems.product');
        return view('cart.success', compact('order'));
    }
}
