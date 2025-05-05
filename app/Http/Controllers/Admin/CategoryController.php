<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str; // Import Str facade
use Illuminate\Http\RedirectResponse; // Import RedirectResponse

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $sortField = $request->input('sort_by', 'name'); // Default sort field
        $sortDirection = $request->input('direction', 'asc'); // Default sort direction

        // Validate sort field to prevent arbitrary column sorting
        $validSortFields = ['name', 'slug', 'created_at']; // Add other sortable fields if needed
        if (!in_array($sortField, $validSortFields)) {
            $sortField = 'name';
        }
        if (!in_array(strtolower($sortDirection), ['asc', 'desc'])) {
            $sortDirection = 'asc';
        }

        $categories = Category::query()
            ->withCount('products') // Eager load product count
            ->when($search, fn ($query, $search) =>
                $query->where(fn($q) =>
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%')
                      ->orWhere('slug', 'like', '%' . $search . '%')
                )
            )
            ->orderBy($sortField, $sortDirection)
            ->paginate(15) // Adjust pagination count as needed
            ->withQueryString(); // Append query string parameters

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
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $this->validateCategory($request);

        // Generate slug if not provided
        $validatedData['slug'] = $validatedData['slug'] ?: Str::slug($validatedData['name']); // Use imported Str

        Category::create($validatedData);

        return redirect()->route('admin.categories.index')->with('status', 'Category created successfully.');
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category): View // Using route model binding
    {
        return view('admin.categories.form', compact('category'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, Category $category): RedirectResponse // Using route model binding
    {
        $validatedData = $this->validateCategory($request, $category);

        // Generate slug if not provided
        $validatedData['slug'] = $validatedData['slug'] ?: Str::slug($validatedData['name']); // Use imported Str

        $category->update($validatedData);

        // Redirect back to the edit form
        return redirect()->route('admin.categories.edit', $category->id)->with('status', 'Category updated successfully.');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Category $category): RedirectResponse // Using route model binding
    {
        // Optional: Add check if category has products before deleting
        // if ($category->products()->count() > 0) {
        //     return redirect()->route('admin.categories.index')->with('error', 'Cannot delete category with associated products.');
        // }
        $category->delete();
        return redirect()->route('admin.categories.index')->with('status', 'Category deleted successfully.');
    }

    /**
     * Validate the request data for storing or updating a category.
     *
     * @param Request $request
     * @param Category|null $category
     * @return array
     */
    private function validateCategory(Request $request, ?Category $category = null): array
    {
        // Base rules
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash', 'unique:categories,slug,' . ($category ? $category->id : null)], // Ensure slug is unique
            'description' => ['nullable', 'string'],
        ];

        return $request->validate($rules);
    }
}