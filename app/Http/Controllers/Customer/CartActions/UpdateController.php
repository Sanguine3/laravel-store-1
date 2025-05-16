<?php

namespace App\Http\Controllers\Customer\CartActions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\Cart\UpdateCartItemRequest;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class UpdateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdateCartItemRequest $request, $productId)
    {
        // Validation (quantity >= 1) is now handled by UpdateCartItemRequest
        $validatedData = $request->validated();
        $quantity = $validatedData['quantity'];

        $cart = Session::get('cart', []);

        if (isset($cart[$productId])) {
            // Optional: Check stock if you want to prevent increasing quantity beyond stock
            $product = Product::find($productId);
            if ($product && $product->stock_quantity < $quantity) {
                return back()->with('error', 'Not enough stock available for the new quantity.');
            }
            $cart[$productId]['quantity'] = $quantity;
            Session::put('cart', $cart);
            return redirect()->route('cart.view')->with('success', 'Cart updated successfully.');
        }

        return redirect()->route('cart.view')->with('error', 'Item not found in cart.');
    }
}
