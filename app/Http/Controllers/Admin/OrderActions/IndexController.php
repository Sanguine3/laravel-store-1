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
        $sortField = $request->input('sort_by', 'created_at'); // Default sort field
        $sortDirection = $request->input('direction', 'desc'); // Default sort direction

        $validSortFields = ['created_at', 'status', 'total_amount', 'id', 'order_number']; // Add 'order_number' if you use it
        if (!in_array($sortField, $validSortFields)) {
            $sortField = 'created_at';
        }
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }

        $orders = Order::with('user') // Eager load user relationship
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('id', 'like', "%{$search}%")
                      ->orWhere('order_number', 'like', "%{$search}%") // Also search by order_number
                      ->orWhereHas('user', function ($userQuery) use ($search) {
                          $userQuery->where('name', 'like', "%{$search}%");
                      });
                });
            })
            ->when($statusFilter, fn($query, $status) => $query->where('status', $status))
            ->orderBy($sortField, $sortDirection)
            ->paginate(15)
            ->withQueryString();

        $statuses = Order::distinct()->pluck('status')->filter()->sort()->values()->all();
        if(empty($statuses)) { // Fallback if no orders exist yet or all statuses are null
            $statuses = ['pending', 'processing', 'shipped', 'completed', 'cancelled'];
        }

        return view('admin.orders.index', compact('orders', 'statuses', 'search', 'statusFilter', 'sortField', 'sortDirection'));
    }
}
