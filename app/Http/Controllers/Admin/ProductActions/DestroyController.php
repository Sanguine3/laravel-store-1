<?php

namespace App\Http\Controllers\Admin\ProductActions;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;

class DestroyController extends Controller
{
    /**
     * Handle the incoming request.
     * Remove the specified product from storage.
     */
    public function __invoke(Product $product): RedirectResponse // Use route model binding
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('status', 'Product deleted successfully.');
    }
}