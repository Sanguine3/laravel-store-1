<?php

namespace App\Http\Controllers\Admin\OrderActions;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     * Display a listing of the orders.
     */
    public function __invoke(Request $request): View
    {
        $search = $request->input('search');
        $statusFilter = $request->input('status');

        $orders = Order::with('user') // Eager load user relationship
        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', '%' . $search . '%') // Search by Order ID
                ->orWhereHas('user', function ($userQuery) use ($search) { // Search by Customer Name
                    $userQuery->where('name', 'like', '%' . $search . '%');
                });
            });
        })
            ->when($statusFilter, fn($query, $status) => $query->where('status', $status))
            ->latest() // Default sort by latest
            ->paginate(15) // Adjust pagination count as needed
            ->withQueryString(); // Append query string parameters

        // Define possible statuses for the filter dropdown
        $statuses = ['pending', 'processing', 'shipped', 'completed', 'cancelled']; // Or fetch from a config/enum

        return view('admin.orders.index', compact('orders', 'statuses', 'search', 'statusFilter'));
    }
}
