<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Session;

class CartComposer
{
    /**
     * Bind data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $cart = Session::get('cart', []);
        // Directly count the number of unique product lines in the cart.
        // If the cart is empty, count($cart) will be 0.
        $cartItemCount = count($cart);
        $view->with('cartItemCount', $cartItemCount);
    }
}
