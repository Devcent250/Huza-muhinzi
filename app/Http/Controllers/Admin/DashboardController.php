<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_farmers' => User::where('role', 'farmer')->count(),
            'total_suppliers' => User::where('role', 'supplier')->count(),
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'completed_orders' => Order::where('status', 'completed')->count(),
        ];

        $recent_farmers = User::where('role', 'farmer')
            ->withCount('products')
            ->latest()
            ->take(5)
            ->get();

        $recent_suppliers = User::where('role', 'supplier')
            ->withCount('orders')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_farmers', 'recent_suppliers'));
    }

    public function farmers()
    {
        $farmers = User::where('role', 'farmer')
            ->withCount('products')
            ->latest()
            ->paginate(10);

        return view('admin.farmers.index', compact('farmers'));
    }

    public function suppliers()
    {
        $suppliers = User::where('role', 'supplier')
            ->withCount('orders')
            ->latest()
            ->paginate(10);

        return view('admin.suppliers.index', compact('suppliers'));
    }

    public function products()
    {
        $products = Product::with(['farmer'])
            ->latest()
            ->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function orders()
    {
        $orders = Order::with(['product', 'supplier'])
            ->latest()
            ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }
}
