<?php

namespace App\Http\Requests;

use App\Models\Product;
use App\Rules\StockAvailable;

class CartItemRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to both add and update.
     */
    public function rules(): array
    {
        $productParam = $this->route('product') ?? $this->route('productId');
        $product = $productParam instanceof Product
            ? $productParam
            : Product::find($productParam);

        return [
            'quantity' => [
                'required',
                'integer',
                'min:1',
                new StockAvailable($product),
            ],
        ];
    }
}
