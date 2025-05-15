<?php

namespace App\Http\Controllers\Admin\DashboardActions;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     * Display the admin dashboard.
     */
    public function __invoke(): View
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
