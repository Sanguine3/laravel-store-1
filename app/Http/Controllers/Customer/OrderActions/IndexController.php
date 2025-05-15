<?php

namespace App\Http\Controllers\Customer\OrderActions;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     * Display a listing of the customer's orders.
     */
    public function __invoke(): View // Removed Request $request as it's not used
    {
        // Fetch all orders for the currently authenticated user
        $orders = Order::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->paginate(10); // Adjust pagination count as needed

        return view('customer.orders.index', compact('orders'));
    }
}
