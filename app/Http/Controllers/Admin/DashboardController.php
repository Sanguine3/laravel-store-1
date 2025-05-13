<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(): View
    {
        $stats = [
            'totalOrders' => Order::count(),
            'pendingOrders' => Order::where('status', 'pending')->count(),
            'totalCustomers' => User::where('role', 'customer')->count(),
            'totalProducts' => Product::count(),
            'recentOrders' => Order::with('user')->latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
