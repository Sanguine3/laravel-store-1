<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $roleFilter = $request->input('role'); // Use 'role' as query param

        $users = User::query()
            ->withTrashed() // Include soft-deleted users
            ->when($search, fn ($query, $search) =>
                $query->where(fn($q) => // Group where clauses
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%')
                )
            )
            ->when($roleFilter, fn($query, $role) =>
                $query->where('role', $role) // Assuming 'role' column exists
            )
            ->orderBy('name') // Default sort by name
            ->paginate(15) // Adjust pagination count as needed
            ->withQueryString(); // Append query string parameters

        // Define roles for filter dropdown
        $roles = ['admin', 'customer']; // Or fetch dynamically if needed

        return view('admin.users.index', compact('users', 'roles', 'search', 'roleFilter'));
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
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validatedData = $this->validateUser($request);

        $validatedData['password'] = \Illuminate\Support\Facades\Hash::make($validatedData['password']);

        User::create($validatedData);

        return redirect()->route('admin.users.index')->with('status', 'User created successfully.');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user): View // Using route model binding
    {
        return view('admin.users.form', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user): \Illuminate\Http\RedirectResponse // Using route model binding
    {
        $validatedData = $this->validateUser($request, $user);

        // Hash password only if provided
        if (!empty($validatedData['password'])) {
            $validatedData['password'] = \Illuminate\Support\Facades\Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']); // Don't update password if empty
        }

        $user->update($validatedData);

        // Redirect back to the edit form
        return redirect()->route('admin.users.edit', $user->id)->with('status', 'User updated successfully.');
    }

    /**
     * Validate the request data for storing or updating a user.
     *
     * @param Request $request
     * @param User|null $user
     * @return array
     */
    private function validateUser(Request $request, ?User $user = null): array
    {
        $userId = $user ? $user->id : null;

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', \Illuminate\Validation\Rule::unique('users')->ignore($userId)->whereNull('deleted_at')],
            'password' => [$user ? 'nullable' : 'required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', \Illuminate\Validation\Rule::in(['admin', 'customer'])],
            // 'status' => ['required', 'string', \Illuminate\Validation\Rule::in(['active', 'inactive'])],
        ];

        return $request->validate($rules);
    }
    /**
    /**
     */
    public function destroy(User $user) // Using route model binding
    {
        if ($user->id === Auth::id()) {
             return redirect()->route('admin.users.index')->with('error', 'You cannot delete yourself.');
        }

        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
             return redirect()->route('admin.users.index')->with('error', 'Cannot delete the last admin user.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('status', 'User deleted successfully.');
    }

    /**
     * Restore the specified soft-deleted user.
     */
    public function restore(User $user): \Illuminate\Http\RedirectResponse
    {
        // Route model binding automatically handles finding the user,
        // including trashed ones if the route parameter is type-hinted
        // and the model uses SoftDeletes.

        if ($user->trashed()) {
            $user->restore();
            return redirect()->route('admin.users.index')->with('status', 'User restored successfully.');
        }

        return redirect()->route('admin.users.index')->with('error', 'User is not deleted or cannot be restored.');
    }
}
