<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the customer's orders.
     */
    public function index(): View
    {
        $orders = Order::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show(Request $request, Order $order)
    {
        if (Auth::id() !== $order->user_id) {
            abort(403, 'You are not authorized to view this order.');
        }

        $order->load(['orderItems.product', 'user']);

        return view('customer.orders.show', compact('order'));
    }
} 