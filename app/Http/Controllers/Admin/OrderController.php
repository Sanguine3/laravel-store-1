<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $statusFilter = $request->input('status');

        $orders = Order::with('user') // Eager load user relationship //dung 2 where toi uu, bo when
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('id', 'like', '%' . $search . '%') // Search by Order ID
                    ->orWhereHas('user', function ($userQuery) use ($search) { // Search by Customer Name
                        $userQuery->where('name', 'like', '%' . $search . '%');
                    });
                });
            })
            ->when($statusFilter, fn($query, $status) => $query->where('status', $status)
            )
            ->latest() // Default sort by latest
            ->paginate(15) // Adjust pagination count as needed
            ->withQueryString(); // Append query string parameters

        // Define possible statuses for the filter dropdown
        $statuses = ['pending', 'processing', 'shipped', 'completed', 'cancelled']; // Or fetch from a config/enum

        return view('admin.orders.index', compact('orders', 'statuses', 'search', 'statusFilter'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order): View // Use route model binding
    {
        // Eager load items and user for the detail view
        $order->load(['orderItems.product', 'user']);

        // Define possible statuses for the update dropdown
        $statuses = ['pending', 'processing', 'shipped', 'completed', 'cancelled'];

        return view('admin.orders.show', compact('order', 'statuses'));
    }

    /**
     * Update the status of the specified order.
     */
    public function updateStatus(Request $request, Order $order): \Illuminate\Http\RedirectResponse
    {
        $statuses = ['pending', 'processing', 'shipped', 'completed', 'cancelled']; // Define or fetch statuses

        $validated = $request->validate([
            'status' => ['required', 'string', \Illuminate\Validation\Rule::in($statuses)],
        ]);

        $order->update(['status' => $validated['status']]);

        return redirect()->route('admin.orders.show', $order->id)->with('status', 'Order status updated successfully.');
    }
}
