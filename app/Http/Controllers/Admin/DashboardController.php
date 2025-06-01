<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Inertia\Inertia;
use App\Libraries\Common;

class DashboardController extends Controller
{
    public function index(): \Inertia\Response
    {
        $stats = [
            'totalRevenue' => Order::sum('total_amount'),
            'totalOrders' => Order::count(),
            'pendingOrders' => Order::where('status', 'pending')->count(),
            'completedOrders' => Order::where('status', 'completed')->count(),
            'totalCustomers' => User::where('role', 'customer')->count(),
            'totalProducts' => Product::count(),
            'newCustomersLast30Days' => User::where('role', 'customer')
                ->where('created_at', '>=', now()->subDays(30))->count(),
            'outOfStockProducts' => Product::where('stock_quantity', '<=', 0)->count(),
            'recentOrders' => Common::paginate(
                Order::with('user')->latest()->get(),
                5
            ),
        ];

        return Inertia::render('Admin/Dashboard/Index', compact('stats'));
    }
} 