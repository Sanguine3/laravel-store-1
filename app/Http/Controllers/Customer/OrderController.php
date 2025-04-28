<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        // Logic from Livewire component will go here
        // For now, fetch all orders for the user
        $orders = Order::where('user_id', Auth::id())
                       ->orderByDesc('created_at')
                       ->paginate(10); // Example pagination

        return view('customer.orders.index', compact('orders'));
    }

    /**
     * Display the specified resource.
     * We might need this later if there's an order detail view.
     */
    // public function show(Order $order): View
    // {
    //     // Authorize user can view this order
    //     if ($order->user_id !== Auth::id()) {
    //         abort(403);
    //     }
    //     return view('customer.orders.show', compact('order'));
    // }
}