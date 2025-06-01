<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request): \Inertia\Response
    {
        $user = $request->user();
        $recentOrders = Order::where('user_id', $user->id)
            ->latest()
            ->limit(5)
            ->get();
        $customerTotalOrders = Order::where('user_id', $user->id)->count();

        return Inertia::render('Customer/Dashboard/Index', [
            'recentOrders' => $recentOrders,
            'customerTotalOrders' => $customerTotalOrders,
        ]);
    }
} 