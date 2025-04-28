<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Dashboard extends Component
{
    public function render()
    {
        // Get total product count (all statuses)
        $totalProducts = Product::query()->count();

        // Get recent orders for current user (limit 5)
        $recentOrders = Order::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return view('dashboard', [
            'totalProducts' => $totalProducts,
            'recentOrders' => $recentOrders,
        ]);
    }
} 