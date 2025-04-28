<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Dashboard extends Component
{
    public int $totalOrders = 0;
    public int $pendingOrders = 0;
    public int $totalCustomers = 0;
    public int $totalProducts = 0;
    public $recentOrders = [];

    public function mount(): void
    {
        $this->totalOrders = Order::count();
        $this->pendingOrders = Order::where('status', 'pending')->count(); // Adjust status as needed
        $this->totalCustomers = User::where('role', 'customer')->count();
        $this->totalProducts = Product::count();
        $this->recentOrders = Order::with('user')->latest()->take(5)->get(); // Example: Get 5 recent orders
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
