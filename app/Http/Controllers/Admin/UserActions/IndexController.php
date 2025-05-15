<?php

namespace App\Http\Controllers\Admin\UserActions;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     * Display a listing of the users.
     */
    public function __invoke(Request $request): View
    {
        $search = $request->input('search');
        $roleFilter = $request->input('role'); // Use 'role' as query param

        $users = User::withTrashed() // Include soft-deleted users
        ->when($search, fn($query, $search) => $query->where(fn($q) => // Group where clauses
        $q->where('name', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%')
        )
        )
            ->when($roleFilter, fn($query, $role) => $query->where('role', $role)
            )
            ->orderBy('name') // Default sort by name
            ->paginate(15) // Adjust pagination count as needed
            ->withQueryString(); // Append query string parameters

        // Define roles for filter dropdown
        $roles = ['admin', 'customer']; // Fetch dynamically if needed

        return view('admin.users.index', compact('users', 'roles', 'search', 'roleFilter'));
    }
}
