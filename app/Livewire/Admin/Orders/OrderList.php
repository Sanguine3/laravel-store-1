<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class OrderList extends Component
{
    use WithPagination;

    // Add search property
    public string $search = '';
    public string $statusFilter = '';

    // Add queryString for search
    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
    ];

    public function render()
    {
        // Placeholder for fetching orders with search
        $orders = Order::query()
            ->with('user') // Eager load user
            ->when($this->search, function ($query, $search) {
                // Basic search on order ID or customer name
                $query->where('id', 'like', '%'.$search.'%')
                      ->orWhereHas('user', function ($q) use ($search) {
                          $q->where('name', 'like', '%'.$search.'%');
                      });
            })
            ->when($this->statusFilter, fn($query, $status) => $query->where('status', $status))
            ->latest()
            ->paginate(10);

        return view('livewire.admin.orders.index', [
            'orders' => $orders,
        ]);
    }
}
