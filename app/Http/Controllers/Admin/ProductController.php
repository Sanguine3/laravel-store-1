<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categoryFilter = $request->input('category'); // Use 'category' as query param
        $statusFilter = $request->input('status');     // Use 'status' as query param

        $products = Product::query()
            ->with('category') // Eager load category relationship
            ->when($search, fn ($query, $search) =>
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('sku', 'like', '%' . $search . '%') // Optional: search SKU too
            )
            ->when($categoryFilter, fn ($query, $categoryId) =>
                $query->where('category_id', $categoryId)
            )
            ->when($statusFilter !== null && $statusFilter !== '', fn ($query, $value) =>
                // Assuming 'is_published' boolean
                $query->where('is_published', $statusFilter === 'published')
            )
            ->orderBy('created_at', 'desc') // Default sort order
            ->paginate(15) // Adjust pagination count as needed
            ->withQueryString(); // Append query string parameters to pagination links

        $categories = Category::query()->orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories', 'search', 'categoryFilter', 'statusFilter'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::query()->orderBy('name')->get();
        return view('admin.products.form', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $this->validateProduct($request);

        // Generate slug from name
        $validatedData['slug'] = \Illuminate\Support\Str::slug($validatedData['name']);

        // Map imageUrl to image field if needed (assuming 'image' is the DB column)
        $validatedData['image'] = $validatedData['image_url'] ?? null;
        unset($validatedData['image_url']); // Remove temporary field

        // Handle boolean checkbox
        $validatedData['is_published'] = $request->has('is_published');

        Product::create($validatedData);

        return redirect()->route('admin.products.index')->with('status', 'Product created successfully.');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product) // Using route model binding
    {
        $categories = Category::orderBy('name', 'desc')->get();
        return view('admin.products.form', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product) // Using route model binding
    {
        $validatedData = $this->validateProduct($request, $product);

        // Generate slug from name
        $validatedData['slug'] = \Illuminate\Support\Str::slug($validatedData['name']);

        // Map imageUrl to image field if needed
        $validatedData['image'] = $validatedData['image_url'] ?? null;
        unset($validatedData['image_url']);

        // Handle boolean checkbox
        $validatedData['is_published'] = $request->has('is_published');

        $product->update($validatedData);
        // Redirect back to the edit form
        return redirect()->route('admin.products.edit', $product->id)->with('status', 'Product updated successfully.');
    }
/**
     * Validate the request data for storing or updating a product.
     *
     * @param Request $request
     * @param Product|null $product
     * @return array
     */
    private function validateProduct(Request $request, ?Product $product = null): array
    {
        // Base rules
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'url', 'max:2048'], // Validate the URL input
            'category_id' => ['required', 'exists:categories,id'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'is_published' => ['nullable'], // Checkbox presence handled in store/update
            // 'sku' => ['nullable', 'string', 'unique:products,sku,' . ($product ? $product->id : null)],
        ];

        return $request->validate($rules);
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product) // Using route model binding
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('status', 'Product deleted successfully.');
    }
}
