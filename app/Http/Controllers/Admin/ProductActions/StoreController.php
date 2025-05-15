<?php

namespace App\Http\Controllers\Admin\ProductActions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\StoreProductRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;

class StoreController extends Controller
{
    /**
     * Handle the incoming request.
     * Store a newly created product in storage.
     */
    public function __invoke(StoreProductRequest $request): RedirectResponse
    {
        // Validation and data preparation (including slug, is_published, image mapping)
        // is handled by the StoreProductRequest class.
        $validatedData = $request->validated();

        Product::create($validatedData);

        return redirect()->route('admin.products.index')->with('status', 'Product created successfully.');
    }
}