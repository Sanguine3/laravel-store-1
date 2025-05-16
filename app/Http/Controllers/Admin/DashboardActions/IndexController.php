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
        $lowStockThreshold = 10; // Define a threshold for low stock

        $stats = [
            'totalOrders' => Order::count(),
            'pendingOrders' => Order::where('status', 'pending')->count(),
            'completedOrders' => Order::where('status', 'completed')->count(), // Added for context
            'totalRevenue' => Order::where('status', 'completed')->sum('total_amount'),
            'totalCustomers' => User::where('role', 'customer')->count(),
            'newCustomersLast30Days' => User::where('role', 'customer')->where('created_at', '>=', now()->subDays(30))->count(),
            'totalProducts' => Product::count(),
            'recentOrders' => Order::with('user')->latest()->take(5)->get(),
            'lowStockProducts' => Product::where('stock_quantity', '>', 0)
                ->where('stock_quantity', '<=', $lowStockThreshold)
                ->orderBy('stock_quantity', 'asc')
                ->take(5)
                ->get(),
            'outOfStockProducts' => Product::where('stock_quantity', '<=', 0)->count(),
        ];

        return view('admin.dashboard', compact('stats', 'lowStockThreshold'));
    }
}
