<?php

namespace App\Http\Requests\Customer\Cart;

use App\Models\Product;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCartItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Assuming any authenticated user can attempt to add to cart
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        /** @var Product $product */
        $product = $this->route('product'); // Get the product from the route model binding

        return [
            'quantity' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) use ($product) {
                    if ($product && $product->stock_quantity < $value) {
                        $fail("Only {$product->stock_quantity} units of {$product->name} are available in stock.");
                    }
                },
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'quantity.min' => 'Quantity must be at least 1.',
        ];
    }
}
