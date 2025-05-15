<?php

namespace App\Http\Controllers\Admin\ProductActions;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\View\View;

class CreateController extends Controller
{
    /**
     * Handle the incoming request.
     * Show the form for creating a new product.
     */
    public function __invoke(): View
    {
        $categories = Category::query()->orderBy('name')->get();
        return view('admin.products.form', compact('categories'));
    }
}