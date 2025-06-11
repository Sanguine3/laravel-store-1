<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Order\UpdateOrderStatusRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $statusFilter = $request->input('status');
        $sortField = $request->input('sort_by', 'created_at');
        $sortDirection = $request->input('direction', 'desc');

        $validSortFields = ['created_at', 'status', 'total_amount', 'id', 'order_number'];
        if (!in_array($sortField, $validSortFields)) {
            $sortField = 'created_at';
        }
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }

        $orders = Order::with('user')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('id', 'like', "%{$search}%")
                      ->orWhere('order_number', 'like', "%{$search}%")
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
        if (empty($statuses)) {
            $statuses = ['pending', 'processing', 'shipped', 'completed', 'cancelled'];
        }

        return view('admin.orders.index', compact(
            'orders',
            'statuses',
            'search',
            'statusFilter',
            'sortField',
            'sortDirection'
        ));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order): View
    {
        $order->load(['orderItems.product', 'user']);
        $statuses = ['pending', 'processing', 'shipped', 'completed', 'cancelled'];

        return view('admin.orders.show', compact('order', 'statuses'));
    }

    /**
     * Update the status of the specified order.
     */
    public function updateStatus(UpdateOrderStatusRequest $request, Order $order): RedirectResponse
    {
        $validated = $request->validated();
        $newStatus = $validated['status'];
        $oldStatus = $order->status;

        $stockDeductionStatuses = ['processing', 'shipped', 'completed'];

        DB::beginTransaction();
        try {
            if (in_array($newStatus, $stockDeductionStatuses) && !in_array($oldStatus, $stockDeductionStatuses)) {
                $order->load('orderItems.product');
                foreach ($order->orderItems as $item) {
                    if ($item->product) {
                        $product = $item->product;
                        $newStock = $product->stock_quantity - $item->quantity;
                        $product->stock_quantity = max(0, $newStock);
                        $product->save();
                    } else {
                        Log::warning("Product not found for order item ID: {$item->id} in order ID: {$order->id} during stock deduction.");
                    }
                }
            }

            $order->update(['status' => $newStatus]);
            DB::commit();

            return redirect()->route('admin.orders.show', $order->id)
                ->with('status', 'Order status updated successfully. Stock levels adjusted if applicable.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error updating order status or stock for order ID {$order->id}: " . $e->getMessage());
            return redirect()->route('admin.orders.show', $order->id)
                ->with('error', 'Failed to update order status. Please try again.');
        }
    }
} 