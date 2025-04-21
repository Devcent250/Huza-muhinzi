<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\View\View;

class SupplierController extends Controller
{
    /**
     * Display the supplier's dashboard.
     *
     * @return \Illuminate\View\Response
     */
    public function dashboard()
    {
        $user = auth()->user();

        $pendingRequests = Order::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();

        $totalRequests = Order::where('user_id', $user->id)->count();

        $recentRequests = Order::where('user_id', $user->id)
            ->with(['product', 'product.user'])
            ->latest()
            ->take(5)
            ->get();

        return view('supplier.dashboard', compact('pendingRequests', 'totalRequests', 'recentRequests'));
    }

    /**
     * Display available products from farmers.
     *
     * @return \Illuminate\View\Response
     */
    public function browseProducts()
    {
        $products = Product::where('status', 'available')
            ->with('user')
            ->latest()
            ->paginate(12);

        return view('supplier.products.browse', compact('products'));
    }

    /**
     * Show the form for making a new request.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\View\Response
     */
    public function createRequest(Product $product)
    {
        if ($product->status !== 'available') {
            return back()->with('error', __('This product is no longer available'));
        }

        return view('supplier.requests.create', compact('product'));
    }

    /**
     * Store a new request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function storeRequest(Request $request, Product $product)
    {
        if ($product->status !== 'available') {
            return back()->with('error', __('This product is no longer available'));
        }

        $validated = $request->validate([
            'quantity' => ['required', 'numeric', 'min:1', 'max:' . $product->quantity],
            'message' => ['nullable', 'string', 'max:255'],
        ]);

        $order = Order::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'quantity' => $validated['quantity'],
            'total_price' => $product->price * $validated['quantity'],
            'message' => $validated['message'],
            'status' => 'pending',
        ]);

        return redirect()->route('supplier.requests.show', $order)
            ->with('success', __('Request sent successfully'));
    }

    /**
     * Display the specified request.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\View\Response
     */
    public function showRequest(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['product', 'product.user']);
        return view('supplier.requests.show', compact('order'));
    }
}
