<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order; // Added
use App\Models\Product; // Added
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Added
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the customer dashboard.
     */
    public function index(): View
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