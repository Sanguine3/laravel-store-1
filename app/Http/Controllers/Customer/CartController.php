<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\Cart\StoreCartItemRequest;
use App\Http\Requests\Customer\Cart\UpdateCartItemRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Display the current cart contents.
     */
    public function view(Request $request): View
    {
        $cart = Session::get('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('customer.cart.index', compact('cart', 'total'));
    }

    /**
     * Add an item to the cart.
     */
    public function add(StoreCartItemRequest $request, Product $product): RedirectResponse
    {
        $validated = $request->validated();
        $quantity = $validated['quantity'];

        $cart = Session::get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => $quantity,
            ];
        }

        Session::put('cart', $cart);

        return back()->with('success', "'$product->name' added to your cart!");
    }

    /**
     * Update the quantity of an item in the cart.
     */
    public function update(UpdateCartItemRequest $request, $productId): RedirectResponse
    {
        $validated = $request->validated();
        $quantity = $validated['quantity'];

        $cart = Session::get('cart', []);

        if (isset($cart[$productId])) {
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

    /**
     * Remove an item from the cart.
     */
    public function remove(Request $request, $productId): RedirectResponse
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put('cart', $cart);
            return redirect()->route('cart.view')->with('success', 'Item removed from cart.');
        }

        return redirect()->route('cart.view')->with('error', 'Item not found in cart.');
    }
}
