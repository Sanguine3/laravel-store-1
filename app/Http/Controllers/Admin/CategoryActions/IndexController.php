<?php

namespace App\Http\Controllers\Admin\CategoryActions;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     * Display a listing of the categories.
     */
    public function __invoke(Request $request): View
    {
        $search = $request->input('search');
        $sortField = $request->input('sort_by', 'name'); // Default sort field
        $sortDirection = $request->input('direction', 'asc'); // Default sort direction

        // Validate sort field to prevent arbitrary column sorting
        $validSortFields = ['name', 'slug', 'created_at'];
        if (!in_array($sortField, $validSortFields)) {
            $sortField = 'name';
        }
        if (!in_array(strtolower($sortDirection), ['asc', 'desc'])) {
            $sortDirection = 'asc';
        }

        $categories = Category::withCount('products') // Eager load product count
        ->when($search, fn($query, $search) => $query->where(fn($q) => $q->where('name', 'like', '%' . $search . '%')
            ->orWhere('description', 'like', '%' . $search . '%')
            ->orWhere('slug', 'like', '%' . $search . '%')
        )
        )
            ->orderBy($sortField, $sortDirection)
            ->paginate(15)
            ->withQueryString(); // Append query string parameters

        return view('admin.categories.index', compact('categories', 'search', 'sortField', 'sortDirection'));
    }
}
