<?php

namespace App\Http\Controllers\Customer\OrderActions;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ShowController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @param Order $order
     * @return View|RedirectResponse
     */
    public function __invoke(Request $request, Order $order)
    {
        // Authorize that the authenticated user owns the order
        if (Auth::id() !== $order->user_id) {
            // Or redirect with an error, or use a proper authorization policy
            abort(403, 'You are not authorized to view this order.');
        }

        // Eager load relationships for display
        $order->load(['orderItems.product', 'user']);

        return view('customer.orders.show', compact('order'));
    }
}
