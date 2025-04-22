<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
// use Livewire\WithFileUploads; // No longer needed
// use Illuminate\Support\Facades\Storage; // No longer needed

#[Layout('components.layouts.admin')]
class ProductForm extends Component
{
    // use WithFileUploads; // Removed

    public ?Product $product = null;

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

    public function mount(?int $id = null): void
    {
        if ($id) {
            $this->product = Product::findOrFail($id);
            $this->name = $this->product->name;
            $this->description = $this->product->description;
            $this->price = $this->product->price;
            // Load image URL from the image_path column
            $this->imageUrl = $this->product->image_path ?? '';
            // Load other properties if needed (e.g., sku, stock, status - though form elements are disabled)
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
        ]);

        // Map imageUrl to image_path for saving
        $validatedData = [
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'image_path' => $validated['imageUrl'], // Save URL to image_path column
            // Add other fields here if/when implemented (e.g., category_id, sku, is_published, stock_quantity)
        ];

        // Removed file upload handling logic

        if ($this->product) {
            $this->product->update($validatedData);
            session()->flash('status', 'Product updated successfully.');
        } else {
            Product::create($validatedData);
            session()->flash('status', 'Product created successfully.');
        }

        return $this->redirect(ProductList::class, navigate: true);
    }

    public function render()
    {
        return view('admin.products.form');
    }
} 