<?php

namespace App\Http\Controllers\Customer\CartActions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ViewController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $cart = Session::get('cart', []);
        $total = 0;

        foreach ($cart as $id => $details) {
            $total += $details['price'] * $details['quantity'];
        }

        // In a real application, you might want to fetch fresh product details
        // from the database here to ensure prices and names are up-to-date,
        // especially if products can be edited frequently.
        // For simplicity, we're using the details stored in the session.

        return view('customer.cart.index', compact('cart', 'total'));
    }
}