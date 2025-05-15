<?php

namespace App\Http\Controllers\Admin\ProductActions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;

class UpdateController extends Controller
{
    /**
     * Handle the incoming request.
     * Update the specified product in storage.
     */
    public function __invoke(UpdateProductRequest $request, Product $product): RedirectResponse // Use route model binding
    {
        // Validation and data preparation (including slug, is_published, image mapping)
        // are handled by the UpdateProductRequest class.
        $validatedData = $request->validated();

        $product->update($validatedData);

        // Redirect back to the edit form
        return redirect()->route('admin.products.edit', $product->id)->with('status', 'Product updated successfully.');
    }
}