<?php

namespace App\Http\Controllers\Admin\ProductActions;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class EditController extends Controller
{
    /**
     * Handle the incoming request.
     * Show the form for editing the specified product.
     */
    public function __invoke(Product $product): View // Use route model binding
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.form', compact('product', 'categories'));
    }
}
