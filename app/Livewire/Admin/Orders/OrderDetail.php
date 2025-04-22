<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class OrderDetail extends Component
{
    public Order $order;

    // Add property to bind status dropdown
    public string $selectedStatus = '';

    // Define available statuses (adjust as needed)
    public array $statuses = ['pending', 'processing', 'completed', 'shipped', 'cancelled'];

    public function mount(int $id): void
    {
        // Placeholder: Load order with relationships (e.g., user, items)
        $this->order = Order::with('user', 'items.product')->findOrFail($id);
        $this->selectedStatus = $this->order->status;
    }

    // Update order status based on selectedStatus property
    public function updateStatus()
    {
        // Validate status
        if (!in_array($this->selectedStatus, $this->statuses)) {
            // Add error feedback (e.g., session flash or component property)
            session()->flash('error', 'Invalid status selected.');
            return;
        }

        $this->order->update(['status' => $this->selectedStatus]);

        // Refresh the order data to reflect the change immediately
        $this->order->refresh();

        // Add success feedback
        session()->flash('status', 'Order status updated successfully.');
    }

    public function render()
    {
        return view('admin.orders.show');
    }
} 