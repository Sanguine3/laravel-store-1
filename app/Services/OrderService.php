<?php

namespace App\Services;

use App\Models\Order;

class OrderService
{
    public function getPaginated(int $perPage = 15)
    {
        return Order::with('user', 'items.product')->paginate($perPage);
    }

    public function get(int $id)
    {
        return Order::with('user', 'items.product')->findOrFail($id);
    }

    public function update(Order $order, array $data)
    {
        $order->update($data);
        return $order;
    }
} 