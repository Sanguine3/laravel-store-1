<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use App\Models\Category; // Import Category model
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
// use Livewire\WithFileUploads; // No longer needed
// use Illuminate\Support\Facades\Storage; // No longer needed

#[Layout('components.layouts.app')]
class ProductForm extends Component
{
    // use WithFileUploads; // Removed

    public ?Product $product = null;
    public $allCategories; // Property to hold categories

    // Placeholder properties based on common product fields
    #[Rule('required|string|max:255')]
    public string $name = '';

    #[Rule('nullable|string')]
    public string $description = '';

    #[Rule('required|numeric|min:0')]
    public $price = 0;

    // Changed from file upload to URL input
    #[Rule('nullable|url|max:2048')]
    public string $imageUrl = '';

    #[Rule('required|exists:categories,id')] // Add category_id property and rule
    public ?int $category_id = null;

    #[Rule('required|integer|min:0')] // Add stock_quantity property and rule
    public int $stock_quantity = 0;

    #[Rule('required|boolean')] // Add is_published property and rule
    public bool $is_published = false; // Default to Draft

    public function mount(?int $id = null): void
    {
        $this->allCategories = Category::query()->orderBy('name')->get(); // Fetch categories

        if ($id) {
            $this->product = Product::findOrFail($id);
            $this->name = $this->product->name;
            $this->description = $this->product->description;
            $this->price = $this->product->price;
            $this->category_id = $this->product->category_id; // Load existing category_id
            // Load image URL from the image column
            $this->imageUrl = $this->product->image ?? '';
            $this->stock_quantity = $this->product->stock_quantity ?? 0; // Load existing stock_quantity
            $this->is_published = $this->product->is_published ?? false; // Load existing status
            // Load other properties if needed (e.g., sku)
        }
    }

    public function save()
    {
        // Adapt validation rules if needed, especially for imageUrl
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'imageUrl' => 'nullable|url|max:2048',
            'category_id' => 'required|exists:categories,id',
            'stock_quantity' => 'required|integer|min:0',
            'is_published' => 'required|boolean',
        ]);

        // Generate slug from name
        $slug = \Str::slug($validated['name']);

        // Map imageUrl to image for saving
        $validatedData = [
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? '',
            'price' => $validated['price'],
            'image' => $validated['imageUrl'] ?? null,
            'category_id' => $validated['category_id'],
            'stock_quantity' => $validated['stock_quantity'],
            'is_published' => $validated['is_published'],
        ];

        if ($this->product) {
            $this->product->update($validatedData);
            session()->flash('status', 'Product updated successfully.');
            // Stay on the same edit page after update
            return null;
        } else {
            Product::create($validatedData);
            session()->flash('status', 'Product created successfully.');
            // Redirect to product list after create
            return redirect()->route('admin.products');
        }
    }

    public function render()
    {
        return view('livewire.admin.products.form', [
            'categories' => $this->allCategories, // Pass categories to the view
        ]);
    }
}
