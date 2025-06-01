<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class CustomerOrderService
{
    public function getUserOrders(int $perPage = 15)
    {
        $user = Auth::user();
        return Order::where('user_id', $user->id)
            ->with('orderItems.product')
            ->paginate($perPage);
    }

    public function getUserOrder($id)
    {
        $user = Auth::user();
        return Order::where('user_id', $user->id)
            ->with('orderItems.product')
            ->findOrFail($id);
    }
} 