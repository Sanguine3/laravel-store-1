<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

// Import for redirection target

class RegisterController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return View
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param Request $request
     * @return RedirectResponse
     *
     * @throws ValidationException
     */
    public function register(RegisterRequest $request)
    {
        // Validation passed, get validated data
        $validated = $request->validated();

        // 2. Create the user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // 3. Dispatch the Registered event
        event(new Registered($user));

        // 4. Log the user in
        Auth::login($user);

        // 5. Redirect the user
        // Redirecting to dashboard.
        // Consider redirecting to RouteServiceProvider::HOME or verification notice if needed.
        return redirect(route('dashboard', absolute: false));
    }
}
