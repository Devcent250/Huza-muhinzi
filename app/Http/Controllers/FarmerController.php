<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;

class FarmerController extends Controller
{
    /**
     * Display the farmer's dashboard.
     *
     * @return \Illuminate\View\Response
     */
    public function dashboard()
    {
        $user = auth()->user();

        $totalProducts = Product::where('user_id', $user->id)->count();
        $pendingRequests = Order::whereHas('product', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('status', 'pending')->count();

        $totalOrders = Order::whereHas('product', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->count();

        $recentRequests = Order::whereHas('product', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['product', 'user'])->latest()->take(5)->get();

        return view('farmer.dashboard', compact('totalProducts', 'pendingRequests', 'recentRequests', 'totalOrders'));
    }

    /**
     * Show the form for creating a new product.
     *
     * @return \Illuminate\View\Response
     */
    public function createProduct()
    {
        return view('farmer.products.create');
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'in:irish potatoes,maize,beans'],
            'quantity' => ['required', 'numeric', 'min:1'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'available_from' => ['required', 'date'],
            'image' => ['nullable', 'image', 'max:2048'], // Max 2MB
        ]);

        $product = new Product();
        $product->user_id = auth()->id();
        $product->name = $validated['name'];
        $product->quantity = $validated['quantity'];
        $product->price = $validated['price'];
        $product->description = $validated['description'];
        $product->available_from = $validated['available_from'];
        $product->unit = 'Kg';
        $product->status = 'available';
        $product->type = str_replace(' ', '_', strtolower($validated['name']));

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $product->image = $path;
        }

        $product->save();

        return redirect()->route('farmer.dashboard')
            ->with('success', __('Product added successfully'));
    }

    /**
     * Display the specified request.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\View\Response
     */
    public function showRequest(Order $order)
    {
        if ($order->product->user_id !== auth()->id()) {
            abort(403);
        }

        return view('farmer.requests.show', compact('order'));
    }

    /**
     * Update the request status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function respondToRequest(Request $request, Order $order)
    {
        if ($order->product->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => ['required', 'in:accepted,rejected'],
            'response_message' => ['nullable', 'string', 'max:255'],
        ]);

        $order->update([
            'status' => $validated['status'],
            'response_message' => $validated['response_message'],
            'responded_at' => now(),
        ]);

        return redirect()->route('farmer.requests.index')
            ->with('success', __('Request response sent successfully'));
    }

    /**
     * Display a listing of the farmer's products.
     *
     * @return \Illuminate\View\Response
     */
    public function products()
    {
        $products = Product::where('user_id', auth()->id())
            ->latest()
            ->paginate(12);

        return view('farmer.products.index', compact('products'));
    }

    /**
     * Display a listing of the farmer's requests.
     *
     * @return \Illuminate\View\Response
     */
    public function requests()
    {
        $requests = Order::whereHas('product', function ($query) {
            $query->where('user_id', auth()->id());
        })->with(['product', 'user'])
            ->latest()
            ->paginate(15);

        return view('farmer.requests.index', compact('requests'));
    }

    /**
     * Display a listing of the farmer's orders.
     *
     * @return \Illuminate\View\Response
     */
    public function orders()
    {
        $orders = Order::whereHas('product', function ($query) {
            $query->where('user_id', auth()->id());
        })->where('status', '!=', 'pending')
            ->with(['product', 'user'])
            ->latest()
            ->paginate(15);

        return view('farmer.orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\View\Response
     */
    public function showOrder(Order $order)
    {
        if ($order->product->user_id !== auth()->id()) {
            abort(403);
        }

        return view('farmer.orders.show', compact('order'));
    }

    /**
     * Update the specified order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function updateOrder(Request $request, Order $order)
    {
        if ($order->product->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => ['required', 'in:completed,cancelled'],
            'notes' => ['nullable', 'string', 'max:255'],
        ]);

        $order->update([
            'status' => $validated['status'],
            'notes' => $validated['notes'],
            'updated_at' => now(),
        ]);

        return redirect()->route('farmer.orders.index')
            ->with('success', __('Order updated successfully'));
    }
}
