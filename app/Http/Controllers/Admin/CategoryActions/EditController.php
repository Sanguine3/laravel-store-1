<?php

namespace App\Http\Controllers\Admin\CategoryActions;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\View\View;

class EditController extends Controller
{
    /**
     * Handle the incoming request.
     * Show the form for editing the specified category.
     */
    public function __invoke(Category $category): View // Use route model binding
    {
        // The controller passes only the category model to the view.
        return view('admin.categories.form', compact('category'));
    }
}
