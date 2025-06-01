<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    private UserService $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $users = $this->service->getPaginated();
        return Inertia::render('Admin/Users/Index', ['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request): RedirectResponse
    {
        $user = $this->service->create($request->validated());
        return redirect()->route('admin.users.index')->with('success', 'User created.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Admin/Users/Create');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): Response
    {
        return Inertia::render('Admin/Users/Edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $this->service->update($user, $request->validated());
        return redirect()->route('admin.users.index')->with('success', 'User updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        $this->service->delete($user);
        return redirect()->route('admin.users.index')->with('success', 'User deleted.');
    }

    /**
     * Restore the specified resource.
     */
    public function restore(int $id): RedirectResponse
    {
        $this->service->restore($id);
        return redirect()->route('admin.users.index')->with('success', 'User restored.');
    }
}
