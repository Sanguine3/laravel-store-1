<?php

namespace App\Http\Controllers\Admin\ProductActions;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     * Display a listing of the products.
     */
    public function __invoke(Request $request): View
    {
        $search = $request->input('search');
        $categoryFilter = $request->input('category'); // Use 'category' as query param
        $statusFilter = $request->input('status');     // Use 'status' as query param

        $products = Product::with('category') // Eager load category relationship
        ->when($search, fn($query, $search) => $query->where('name', 'like', '%' . $search . '%')
            ->orWhere('sku', 'like', '%' . $search . '%') // Optional: search SKU too
        )
            ->when($categoryFilter, fn($query, $categoryId) => $query->where('category_id', $categoryId)
            )
            ->when($statusFilter !== null && $statusFilter !== '', fn($query, $value) => $query->where('is_published', $statusFilter === 'published')
            )
            ->orderBy('created_at', 'desc') // Default sort order
            ->paginate(15)
            ->withQueryString(); // Append query string parameters to pagination links

        $categories = Category::query()->orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories', 'search', 'categoryFilter', 'statusFilter'));
    }
}
