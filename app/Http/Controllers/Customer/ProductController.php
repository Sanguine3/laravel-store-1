<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category; // Added
use App\Models\Product;
use Illuminate\Http\Request; // Added
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(Request $request): View // Added Request
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

        // Fetch products with filters and sorting
        $productsQuery = Product::query()
            ->with('category') // Eager load category
            ->where('is_published', true) // Use is_published from ProductIndex
            ->when($search, fn ($query, $search) =>
                $query->where(function($q) use ($search) { // Group search conditions
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%');
                })
            )
            ->when($categoryFilter, fn ($query, $categoryId) =>
                $query->where('category_id', $categoryId)
            )
            ->orderBy($sortField, $sortDirection);

        $products = $productsQuery->paginate(12)->withQueryString(); // Append query string to pagination links

        // Fetch categories for the filter dropdown
        $categories = Category::query()->orderBy('name')->get();

        return view('customer.products.index', compact('products', 'categories', 'search', 'categoryFilter', 'sortField', 'sortDirection'));
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product): View
    {
        // Ensure the product is published before showing
        if (!$product->is_published) { // Use is_published from ProductDetail logic
             abort(404);
        }

        // Eager load category if the view needs it (based on ProductDetail logic)
        $product->load('category');

        return view('customer.products.show', compact('product'));
    }
}