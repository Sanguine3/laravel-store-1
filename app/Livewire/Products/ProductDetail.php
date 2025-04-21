<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\On;

class ProductDetail extends Component
{
    public $showModal = false;
    public $productId = null;
    public $product = null;
    public $loading = false;
    public $error = null;

    public function mount($productId = null)
    {
        if ($productId) {
            $this->showProductDetail($productId);
        }
    }

    #[On('showProductDetail')]
    public function showProductDetail($productId)
    {
        $this->loading = true;
        $this->showModal = true;
        $this->productId = $productId;
        $this->error = null;

        try {
            $this->product = Product::findOrFail($productId);
        } catch (\Exception $e) {
            $this->error = 'Product not found or an error occurred.';
        } finally {
            $this->loading = false;
        }
    }

    public function returnToProducts()
    {
        $this->showModal = false;
        $this->productId = null;
        $this->product = null;
        $this->error = null;
    }

    public function render()
    {
        return view('livewire.products.product-detail');
    }
}
