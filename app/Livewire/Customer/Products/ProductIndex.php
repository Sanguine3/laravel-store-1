<?php

namespace App\Livewire\Products;

use App\Models\Product;
use App\Models\Category;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('components.layouts.app')] // Use customer app layout
class ProductIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public string $categoryFilter = '';
    public $allCategories;

    protected $queryString = [
        'search' => ['except' => ''],
        'categoryFilter' => ['except' => ''],
    ];

    public function mount(): void
    {
        // Fetch categories once for the filter dropdown
        $this->allCategories = Category::query()->orderBy('name')->get();
    }

    public function render()
    {
        $products = Product::query()
            ->with('category') // Eager load for display
            ->where('is_published', true) // Only show published products
            ->when($this->search, fn ($query, $search) =>
                $query->where('name', 'like', '%' . $search . '%')
                      // Add search on description or sku if desired
                      // ->orWhere('description', 'like', '%' . $search . '%')
            )
            ->when($this->categoryFilter, fn ($query, $categoryId) =>
                $query->where('category_id', $categoryId)
            )
            ->latest() // Or sort by name, price, etc.
            ->paginate(12); // Adjust page size as needed

        return view('livewire.products.product-index', [
            'products' => $products,
            'categories' => $this->allCategories,
        ]);
    }
} 