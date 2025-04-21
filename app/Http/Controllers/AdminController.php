<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\View\Response
     */
    public function dashboard()
    {
        // Get statistics for the dashboard
        $stats = [
            'total_users' => User::count(),
            'total_farmers' => User::where('role', 'farmer')->count(),
            'total_suppliers' => User::where('role', 'supplier')->count(),
            'recent_users' => User::latest()->take(5)->get(),
            'recent_orders' => Order::with(['user'])->latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    /**
     * Show the list of users.
     *
     * @return \Illuminate\View\Response
     */
    public function users()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the list of farmers.
     *
     * @return \Illuminate\View\Response
     */
    public function farmers()
    {
        $farmers = User::where('role', 'farmer')->paginate(10);
        return view('admin.farmers.index', compact('farmers'));
    }

    /**
     * Show the list of suppliers.
     *
     * @return \Illuminate\View\Response
     */
    public function suppliers()
    {
        $suppliers = User::where('role', 'supplier')->paginate(10);
        return view('admin.suppliers.index', compact('suppliers'));
    }
}
