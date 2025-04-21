<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index(): View
    {
        $orders = Order::whereHas('product', function ($query) {
            $query->where('user_id', auth()->id());
        })->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new order.
     */
    public function create(Product $product): View
    {
        return view('orders.create', compact('product'));
    }

    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->quantity,
            'delivery_address' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $order = new Order($validated);
        $order->user_id = auth()->id();
        $order->product_id = $product->id;
        $order->total_price = $product->price * $validated['quantity'];
        $order->status = 'pending';
        $order->save();

        // Update product quantity
        $product->decrement('quantity', $validated['quantity']);

        return redirect()->route('orders.index')
            ->with('success', 'Order placed successfully.');
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order): View
    {
        $this->authorize('view', $order);
        return view('orders.show', compact('order'));
    }

    /**
     * Update the specified order status.
     */
    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $this->authorize('update', $order);

        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order->update($validated);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order status updated successfully.');
    }
}
