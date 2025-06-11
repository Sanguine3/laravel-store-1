<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\StoreCategoryRequest;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sortField = $request->input('sort_by', 'name');
        $sortDirection = $request->input('direction', 'asc');

        $validSortFields = ['name', 'slug', 'created_at'];
        if (!in_array($sortField, $validSortFields)) {
            $sortField = 'name';
        }
        if (!in_array(strtolower($sortDirection), ['asc', 'desc'])) {
            $sortDirection = 'asc';
        }

        $categories = Category::withCount('products')
            ->when($search, fn($query, $search) => $query->where(fn($q) =>
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
            ))
            ->orderBy($sortField, $sortDirection)
            ->paginate(15)
            ->withQueryString();

        // Return JSON for API requests
        if ($request->wantsJson()) {
            return response()->json($categories);
        }

        return view('admin.categories.index', compact('categories', 'search', 'sortField', 'sortDirection'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create(): View
    {
        return view('admin.categories.form');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        Category::create($validated);
        Cache::forget('categories.all_sorted_by_name');

        return redirect()->route('admin.categories.index')
            ->with('status', 'Category created successfully.');
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category): View
    {
        return view('admin.categories.form', compact('category'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $validated = $request->validated();
        $category->update($validated);
        Cache::forget('categories.all_sorted_by_name');

        return redirect()->route('admin.categories.edit', $category->id)
            ->with('status', 'Category updated successfully.');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Cannot delete category with associated products.');
        }

        $category->delete();
        Cache::forget('categories.all_sorted_by_name');

        return redirect()->route('admin.categories.index')
            ->with('status', 'Category deleted successfully.');
    }
} 