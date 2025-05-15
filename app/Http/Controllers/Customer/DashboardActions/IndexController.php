<?php

namespace App\Http\Controllers\Customer\DashboardActions;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     * Display the customer dashboard.
     */
    public function __invoke(): View
    {
        // Get total product count (all statuses)
        $totalProducts = Product::query()->count();

        // Get recent orders for current user (limit 5)
        $recentOrders = Order::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        // Pass data to the view
        return view('customer.dashboard', [
            'totalProducts' => $totalProducts,
            'recentOrders' => $recentOrders,
        ]);
    }
}
