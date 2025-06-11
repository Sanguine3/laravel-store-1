<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\StoreUserRequest;
use App\Http\Requests\Admin\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $roleFilter = $request->input('role');
        $userStateFilter = $request->input('user_state');
        $sortField = $request->input('sort_by', 'created_at');
        $sortDirection = $request->input('direction', 'desc');

        $validSortFields = ['name', 'email', 'created_at', 'role'];
        if (!in_array($sortField, $validSortFields)) {
            $sortField = 'created_at';
        }
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }

        $users = User::query()
            ->when($userStateFilter === 'deleted', fn($q) => $q->onlyTrashed())
            ->when($userStateFilter === 'active', fn($q) => $q->whereNull('deleted_at'))
            ->when($userStateFilter === null || $userStateFilter === '', fn($q) => $q->withTrashed())
            ->when($search, fn($q, $s) => $q->where(fn($qq) =>
                $qq->where('name', 'like', "%{$s}%")
                   ->orWhere('email', 'like', "%{$s}%")
            ))
            ->when($roleFilter, fn($q, $role) => $q->where('role', $role))
            ->orderBy($sortField, $sortDirection)
            ->paginate(15)
            ->withQueryString();

        $roles = User::distinct()->pluck('role')->filter()->sort()->values()->all();
        if (empty($roles)) {
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

    /**
     * Show the form for creating a new user.
     */
    public function create(): View
    {
        return view('admin.users.form');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('status', 'User created successfully.');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user): View
    {
        return view('admin.users.form', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $validated = $request->validated();
        $user->update($validated);

        return redirect()->route('admin.users.edit', $user->id)
            ->with('status', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage (soft delete).
     */
    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot delete yourself.');
        }

        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Cannot delete the last admin user.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('status', 'User deleted successfully.');
    }

    /**
     * Restore the specified soft-deleted user.
     */
    public function restore($id): RedirectResponse
    {
        $user = User::withTrashed()->findOrFail($id);
        if ($user->trashed()) {
            $user->restore();
            return redirect()->route('admin.users.index')
                ->with('status', 'User restored successfully.');
        }

        return redirect()->route('admin.users.index')
            ->with('error', 'User is not deleted or cannot be restored.');
    }
} 