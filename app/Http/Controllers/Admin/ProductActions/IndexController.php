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
        $statusFilter = $request->input('status');     // Published status filter
        $stockStatusFilter = $request->input('stock_status');
        $sortField = $request->input('sort_by', 'created_at'); // Default sort: created_at
        $sortDirection = $request->input('direction', 'desc'); // Default direction: desc

        $lowStockThreshold = 10; // Define this here or get from config

        $validSortFields = ['created_at', 'name', 'price', 'stock_quantity', 'is_published'];
        if (!in_array($sortField, $validSortFields)) {
            $sortField = 'created_at';
        }
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }

        $products = Product::with('category') // Eager load category relationship
        ->when($search, fn($query, $search) => $query->where('name', 'like', "%{$search}%")
            ->orWhere('sku', 'like', "%{$search}%")
        )
            ->when($categoryFilter, fn($query, $categoryId) => $query->where('category_id', $categoryId)
            )
            ->when($statusFilter !== null && $statusFilter !== '', fn($query) => // Published status
            $query->where('is_published', $statusFilter === 'published')
            )
            ->when($stockStatusFilter, function ($query) use ($stockStatusFilter, $lowStockThreshold) { // Stock status
                if ($stockStatusFilter === 'in_stock') {
                    return $query->where('stock_quantity', '>', $lowStockThreshold);
                } elseif ($stockStatusFilter === 'low_stock') {
                    return $query->where('stock_quantity', '>', 0)->where('stock_quantity', '<=', $lowStockThreshold);
                } elseif ($stockStatusFilter === 'out_of_stock') {
                    return $query->where('stock_quantity', '<=', 0);
                }
                return $query;
            })
            ->orderBy($sortField, $sortDirection)
            ->paginate(15)
            ->withQueryString(); // Append query string parameters to pagination links

        $categories = Category::query()->orderBy('name')->get();
        $stockStatusOptions = [ // For the dropdown in the view
            '' => 'All Stock Statuses',
            'in_stock' => 'In Stock',
            'low_stock' => 'Low Stock (≤' . $lowStockThreshold . ')',
            'out_of_stock' => 'Out of Stock',
        ];

        return view('admin.products.index', compact(
            'products',
            'categories',
            'search',
            'categoryFilter',
            'statusFilter',
            'stockStatusFilter',
            'stockStatusOptions',
            'lowStockThreshold',
            'sortField',          // Pass sort field
            'sortDirection'     // Pass sort direction
        ));
    }
}
