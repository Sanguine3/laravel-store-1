<?php

namespace App\Http\Controllers\Admin\OrderActions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Order\UpdateOrderStatusRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;

class UpdateStatusController extends Controller
{
    /**
     * Handle the incoming request.
     * Update the status of the specified order.
     */
    public function __invoke(UpdateOrderStatusRequest $request, Order $order): RedirectResponse // Use route model binding
    {
        // Validation is handled by UpdateOrderStatusRequest
        $validatedData = $request->validated();

        $order->update(['status' => $validatedData['status']]);

        return redirect()->route('admin.orders.show', $order->id)->with('status', 'Order status updated successfully.');
    }
}