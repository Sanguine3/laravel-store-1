<?php

namespace App\Http\Controllers\Customer\CartActions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RemoveController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $productId)
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