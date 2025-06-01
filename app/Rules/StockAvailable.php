<?php

namespace App\Rules;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class StockAvailable implements ValidationRule
{
    protected ?Product $product;

    /**
     * Create a new rule instance.
     */
    public function __construct($product)
    {
        if ($product instanceof Product) {
            $this->product = $product;
        } elseif ($product) {
            $this->product = Product::find($product);
        } else {
            $this->product = null;
        }
    }

    /**
     * Run the validation rule.
     *
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->product) {
            $fail('The selected product is invalid.');
            return;
        }

        if ($this->product->stock_quantity < $value) {
            $fail("Only {$this->product->stock_quantity} units of {$this->product->name} are available in stock.");
        }
    }
}
