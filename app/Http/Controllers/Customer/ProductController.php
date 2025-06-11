<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the products for customers.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search', '');
        $categoryFilter = $request->query('category', '');
        $sortField = $request->query('sort_by', 'name');
        $sortDirection = $request->query('direction', 'asc');

        $validSortFields = ['name', 'price', 'created_at'];
        if (!in_array($sortField, $validSortFields)) {
            $sortField = 'name';
        }
        if (!in_array(strtolower($sortDirection), ['asc', 'desc'])) {
            $sortDirection = 'asc';
        }

        $productsQuery = Product::with('category')
            ->where('is_published', true)
            ->when($search, fn($query, $search) => $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            }))
            ->when($categoryFilter, fn($query, $categoryId) => $query->where('category_id', $categoryId))
            ->orderBy($sortField, $sortDirection);

        $products = $productsQuery->paginate(12)->withQueryString();

        $categories = Cache::remember('categories.all_sorted_by_name', now()->addHours(24), function () {
            return Category::orderBy('name')->get();
        });

        return view('customer.products.index', compact(
            'products',
            'categories',
            'search',
            'categoryFilter',
            'sortField',
            'sortDirection'
        ));
    }

    /**
     * Display the specified product to customers.
     */
    public function show(Product $product): View
    {
        if (!$product->is_published) {
            abort(404);
        }

        $product->load('category');

        return view('customer.products.show', compact('product'));
    }
} 