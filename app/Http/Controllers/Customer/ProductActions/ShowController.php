<?php

namespace App\Http\Controllers\Customer\ProductActions;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\View\View;

class ShowController extends Controller
{
    /**
     * Handle the incoming request.
     * Display the specified product to customers.
     */
    public function __invoke(Product $product): View
    {
        // Ensure the product is published before showing
        if (!$product->is_published) {
             abort(404);
        }

        // Eager load category if the view needs it
        $product->load('category');

        return view('customer.products.show', compact('product'));
    }
}