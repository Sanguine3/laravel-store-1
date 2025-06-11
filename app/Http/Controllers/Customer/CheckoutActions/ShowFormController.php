<?php

namespace App\Http\Controllers\Customer\CheckoutActions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ShowFormController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.view')->with('error', 'Your cart is empty. Please add items before proceeding to checkout.');
        }

        // You can pass any necessary data to the checkout view,
        // e.g., user's default address if logged in.
        $user = $request->user();

        return view('customer.checkout.index', compact('user', 'cart'));
    }
}
