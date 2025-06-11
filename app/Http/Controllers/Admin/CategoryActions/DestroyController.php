<?php

namespace App\Http\Controllers\Admin\CategoryActions;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;

class DestroyController extends Controller
{
    /**
     * Handle the incoming request.
     * Remove the specified category from storage.
     */
    public function __invoke(Category $category): RedirectResponse // Use route model binding
    {
        // Check if category has associated products before deleting
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories.index')->with('error', 'Cannot delete category with associated products.');
        }

        $category->delete();
        Cache::forget('categories.all_sorted_by_name'); // Clear the cache
        return redirect()->route('admin.categories.index')->with('status', 'Category deleted successfully.');
    }
}
