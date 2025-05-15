<?php

namespace App\Http\Controllers\Admin\CategoryActions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;

class UpdateController extends Controller
{
    /**
     * Handle the incoming request.
     * Update the specified category in storage.
     */
    public function __invoke(UpdateCategoryRequest $request, Category $category): RedirectResponse // Use route model binding
    {
        // Validation and slug generation are handled by UpdateCategoryRequest
        $validatedData = $request->validated();

        $category->update($validatedData);

        // Redirect back to the edit form
        return redirect()->route('admin.categories.edit', $category->id)->with('status', 'Category updated successfully.');
    }
}