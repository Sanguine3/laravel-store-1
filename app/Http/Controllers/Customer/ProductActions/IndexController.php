<?php

namespace App\Http\Controllers\Customer\ProductActions;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     * Display a listing of the products for customers.
     */
    public function __invoke(Request $request): View
    {
        // Get request parameters for filtering and sorting
        $search = $request->query('search', '');
        $categoryFilter = $request->query('category', ''); // Use 'category' query param
        $sortField = $request->query('sort_by', 'name'); // Default sort
        $sortDirection = $request->query('direction', 'asc'); // Default direction

        // Validate sort field
        $validSortFields = ['name', 'price', 'created_at']; // Add other valid fields
        if (!in_array($sortField, $validSortFields)) {
            $sortField = 'name';
        }
        if (!in_array(strtolower($sortDirection), ['asc', 'desc'])) {
            $sortDirection = 'asc';
        }

        // Fetch products with filters and sort
        $productsQuery = Product::with('category') // Eager load category
        ->where('is_published', true)
            ->when($search, fn($query, $search) => $query->where(function ($q) use ($search) { // Group search conditions
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            })
            )
            ->when($categoryFilter, fn($query, $categoryId) => $query->where('category_id', $categoryId)
            )
            ->orderBy($sortField, $sortDirection);

        $products = $productsQuery->paginate(12)->withQueryString();

        // Fetch categories for the filter dropdown, now with caching
        $categories = Cache::remember('categories.all_sorted_by_name', now()->addHours(24), function () {
            return Category::query()->orderBy('name')->get();
        });

        return view('customer.products.index', compact('products', 'categories', 'search', 'categoryFilter', 'sortField', 'sortDirection'));
    }
}
