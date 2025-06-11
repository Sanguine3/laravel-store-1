<?php

namespace App\Http\Controllers\Admin\OrderActions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Order\UpdateOrderStatusRequest;
use App\Models\Order;
use App\Models\Product; // Added
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB; // Added
use Illuminate\Support\Facades\Log; // Added for logging potential issues

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
        $newStatus = $validatedData['status'];
        $oldStatus = $order->status;

        // Define statuses that trigger stock deduction
        $stockDeductionStatuses = ['processing', 'shipped', 'completed'];

        DB::beginTransaction();
        try {
            // Deduct stock if moving into a stock-deducting status for the first time
            if (in_array($newStatus, $stockDeductionStatuses) && !in_array($oldStatus, $stockDeductionStatuses)) {
                $order->load('orderItems.product'); // Eager load for efficiency

                foreach ($order->orderItems as $item) {
                    if ($item->product) {
                        $product = $item->product;
                        // Ensure stock doesn't go negative, though ideally this is checked before allowing order.
                        // For simplicity here, we just decrement. Add checks if needed.
                        $newStock = $product->stock_quantity - $item->quantity;
                        $product->stock_quantity = max(0, $newStock); // Prevent negative stock
                        $product->save();
                    } else {
                        // Log if a product associated with an order item is missing
                        Log::warning("Product not found for order item ID: {$item->id} in order ID: {$order->id} during stock deduction.");
                    }
                }
            }

            $order->update(['status' => $newStatus]);

            DB::commit();

            return redirect()->route('admin.orders.show', $order->id)->with('status', 'Order status updated successfully. Stock levels adjusted if applicable.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error updating order status or stock for order ID {$order->id}: " . $e->getMessage());
            return redirect()->route('admin.orders.show', $order->id)->with('error', 'Failed to update order status. Please try again.');
        }
    }
}