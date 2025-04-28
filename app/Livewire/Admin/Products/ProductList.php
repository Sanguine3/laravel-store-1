<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\Category;

#[Layout('components.layouts.app')]
class ProductList extends Component
{
    use WithPagination;

    public string $search = '';
    public string $categoryFilter = '';
    public string $statusFilter = '';

    public $allCategories; // Property to hold categories

    protected $queryString = [
        'search' => ['except' => ''],
        'categoryFilter' => ['except' => ''],
        'statusFilter' => ['except' => ''],
    ];

    // Fetch categories once on component mount
    public function mount(): void
    {
        $this->allCategories = Category::query()->orderBy('name')->get();
    }

    public function render()
    {
        $products = Product::query()
            ->with('category')
            ->when($this->search, fn ($query, $search) => $query->where('name', 'like', '%' . $search . '%'))
            ->when($this->categoryFilter, fn ($query, $categoryId) => $query->where('category_id', $categoryId))
            ->when($this->statusFilter, fn ($query, $status) =>
                // Assuming 'is_published' boolean, adjust if status stored differently
                $query->where('is_published', $status === 'published')
            )
            ->paginate(10);

        return view('livewire.admin.products.index', [
            'products' => $products,
            'categories' => $this->allCategories, // Pass stored categories to view
        ]);
    }

    public function delete(int $id): void
    {
        Product::findOrFail($id)->delete();
        // Add feedback
        session()->flash('status', 'Product deleted successfully.');
    }
}
