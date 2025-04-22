<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductDetail extends Component
{
    protected $listeners = ['setProduct'];

    public bool $showModal = false;
    public ?Product $product = null;
    public bool $loading = false;
    public ?string $error = null;

    // Removed #[On] listener

    public function setProduct($productId): void
    {
        $this->resetError();
        $this->product = null;
        $this->showModal = true;
        $this->loadProduct($productId);
    }

    public function loadProduct($productId): void
    {
        $this->loading = true;
        $this->error = null;

        try {
            // Fetch only published products
            $this->product = Product::with('category') // Eager load category if needed in modal view
                                     ->where('is_published', true)
                                     ->findOrFail($productId);
        } catch (ModelNotFoundException $e) {
            $this->error = 'Product not found.';
        } catch (\Exception $e) {
            $this->error = 'An error occurred while loading the product.';
            Log::error("Error loading product {$productId}: " . $e->getMessage()); // Log for debugging
        } finally {
            $this->loading = false;
        }
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->product = null;
        $this->resetError();
    }

    public function resetError(): void
    {
        $this->error = null;
    }

    public function render()
    {
        return view('livewire.products.product-detail');
    }
}
