<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:supplier')->except(['index', 'show']);
    }

    /**
     * Display a listing of the products.
     */
    public function index(): View
    {
        $products = Product::where('user_id', auth()->id())->paginate(10);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create(): View
    {
        $this->authorize('create', Product::class);
        return view('products.create');
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Product::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category' => 'required|string|in:Seeds,Fertilizers,Pesticides,Equipment,Other',
        ]);

        $validated['user_id'] = auth()->id();

        // If user is a cooperative member, set the cooperative_id
        if (auth()->user()->role === 'cooperative_member') {
            $validated['cooperative_id'] = auth()->user()->cooperative_id;
        }

        Product::create($validated);

        return redirect()->route('supplier.products')
            ->with('success', __('Product created successfully.'));
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product): View
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product): View
    {
        $this->authorize('update', $product);
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $this->authorize('update', $product);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category' => 'required|string|in:Seeds,Fertilizers,Pesticides,Equipment,Other',
        ]);

        $product->update($validated);

        return redirect()->route('supplier.products')
            ->with('success', __('Product updated successfully.'));
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $this->authorize('delete', $product);

        $product->delete();

        return redirect()->route('supplier.products')
            ->with('success', __('Product deleted successfully.'));
    }
}
