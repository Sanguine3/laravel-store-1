<?php

namespace App\Livewire;

use App\Models\Product;
// use App\Models\Order; // Removed
// use App\Models\Category; // Removed
// use Illuminate\Support\Facades\Auth; // Removed
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Dashboard extends Component
{
    public function render()
    {
        // Get total product count (all statuses)
        $totalProducts = Product::query()->count();

        // Removed category count query
        // Removed user order count query

        return view('dashboard', [
            'totalProducts' => $totalProducts,
            // 'totalCategories' => $totalCategories, // Removed
            // 'userOrderCount' => $userOrderCount, // Removed
        ]);
    }
} 