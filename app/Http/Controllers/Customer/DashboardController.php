<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the customer dashboard.
     */
    public function index(): View
    {
        $customerTotalOrders = Order::where('user_id', Auth::id())->count();

        $recentOrders = Order::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return view('customer.dashboard', compact('customerTotalOrders', 'recentOrders'));
    }
} 