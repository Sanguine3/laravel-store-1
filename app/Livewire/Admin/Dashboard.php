<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class Dashboard extends Component
{
    public int $totalOrders = 0;
    public int $pendingOrders = 0;
    public int $totalCustomers = 0;
    public int $totalProducts = 0;
    public $recentOrders = [];

    public function mount(): void
    {
        // Placeholder data - Replace with actual queries
        $this->totalOrders = Order::count();
        $this->pendingOrders = Order::where('status', 'pending')->count(); // Adjust status as needed
        $this->totalCustomers = User::whereDoesntHave('roles', fn($q) => $q->where('name', 'admin'))->count(); // Example: Count non-admin users
        $this->totalProducts = Product::count();
        $this->recentOrders = Order::with('user')->latest()->take(5)->get(); // Example: Get 5 recent orders
    }

    public function render()
    {
        return view('admin.dashboard');
    }
} 