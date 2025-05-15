<?php

namespace App\Http\Controllers\Admin\CategoryActions;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class CreateController extends Controller
{
    /**
     * Handle the incoming request.
     * Show the form for creating a new category.
     */
    public function __invoke(): View
    {
        // The controller simply returns the view.
        return view('admin.categories.form');
    }
}
