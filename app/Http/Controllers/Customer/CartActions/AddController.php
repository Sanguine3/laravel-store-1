<?php

namespace App\Http\Controllers\Customer\CartActions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\Cart\StoreCartItemRequest;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class AddController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreCartItemRequest $request, Product $product)
    {
        // Validation is now handled by StoreCartItemRequest
        $validatedData = $request->validated();
        $quantity = $validatedData['quantity'];

        $cart = Session::get('cart', []);

        if (isset($cart[$product->id])) {
            // Product exists in cart, update quantity
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            // Add new product to cart
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => $quantity,
            ];
        }

        Session::put('cart', $cart);

        return back()->with('success', "'{$product->name}' added to your cart!");
    }
}
