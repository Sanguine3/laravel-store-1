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
        $roleFilter = $request->input('role');
        $userStateFilter = $request->input('user_state'); // 'active', 'deleted'
        $sortField = $request->input('sort_by', 'created_at'); // Default sort: joined date
        $sortDirection = $request->input('direction', 'desc'); // Default direction: newest first

        $validSortFields = ['name', 'email', 'created_at', 'role'];
        if (!in_array($sortField, $validSortFields)) {
            $sortField = 'created_at';
        }
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }

        $users = User::query()
            ->when($userStateFilter === 'deleted', fn($query) => $query->onlyTrashed())
            ->when($userStateFilter === 'active', fn($query) => $query->whereNull('deleted_at'))
            ->when($userStateFilter === null || $userStateFilter === '', fn($query) => $query->withTrashed()) // Default to show all including trashed
            ->when($search, fn($query, $search) => $query->where(fn($q) => $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
            )
            )
            ->when($roleFilter, fn($query, $role) => $query->where('role', $role)
            )
            ->orderBy($sortField, $sortDirection)
            ->paginate(15)
            ->withQueryString();

        // Define roles for filter dropdown
        $roles = User::distinct()->pluck('role')->filter()->sort()->values()->all();
        if (empty($roles)) { // Fallback
            $roles = ['admin', 'customer'];
        }

        $userStateOptions = [
            '' => 'All States',
            'active' => 'Active',
            'deleted' => 'Deleted',
        ];

        return view('admin.users.index', compact(
            'users',
            'roles',
            'search',
            'roleFilter',
            'userStateFilter',
            'userStateOptions',
            'sortField',
            'sortDirection'
        ));
    }
}
