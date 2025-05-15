<?php

namespace App\Http\Controllers\Admin\CategoryActions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;

class StoreController extends Controller
{
    /**
     * Handle the incoming request.
     * Store a newly created category in storage.
     */
    public function __invoke(StoreCategoryRequest $request): RedirectResponse
    {
        // Validation and slug generation are handled by StoreCategoryRequest
        $validatedData = $request->validated();

        Category::create($validatedData);

        return redirect()->route('admin.categories.index')->with('status', 'Category created successfully.');
    }
}