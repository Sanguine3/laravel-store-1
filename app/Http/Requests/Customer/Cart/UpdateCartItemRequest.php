<?php

namespace App\Http\Requests\Customer\Cart;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCartItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        // $productId = $this->route('productId');
        // $product = Product::find($productId); // If you need to check stock

        return [
            'quantity' => [
                'required',
                'integer',
                'min:1',
                // Example stock check if re-enabled in controller or moved here:
                // function ($attribute, $value, $fail) use ($product) {
                //     if ($product && $product->stock_quantity < $value) {
                //         $fail("Only {$product->stock_quantity} units are available in stock.");
                //     }
                // },
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
            'quantity.min' => 'Quantity must be at least 1. To remove an item, please use the remove button.',
        ];
    }
}
