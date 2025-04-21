<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\View\View;

class CooperativeController extends Controller
{
    /**
     * Display the cooperative dashboard.
     */
    public function dashboard(): View
    {
        $products = Product::where('user_id', auth()->id())->count();
        $orders = Order::whereHas('product', function ($query) {
            $query->where('user_id', auth()->id());
        })->count();

        return view('cooperative.dashboard', [
            'totalProducts' => $products,
            'totalOrders' => $orders,
        ]);
    }
}
