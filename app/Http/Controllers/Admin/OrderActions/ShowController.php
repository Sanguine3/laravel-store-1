<?php

namespace App\Http\Controllers\Admin\OrderActions;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\View\View;

class ShowController extends Controller
{
    /**
     * Handle the incoming request.
     * Display the specified order.
     */
    public function __invoke(Order $order): View // Use route model binding
    {
        // Eager load items and user for the detail view
        $order->load(['orderItems.product', 'user']);

        // Define possible statuses for the update dropdown
        $statuses = ['pending', 'processing', 'shipped', 'completed', 'cancelled'];

        return view('admin.orders.show', compact('order', 'statuses'));
    }
}
