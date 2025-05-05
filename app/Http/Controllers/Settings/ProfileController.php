<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Keep Auth facade for consistency or use $request->user()
use Illuminate\Validation\Rule;
use App\Models\User; // Assuming User model is in App\Models

class ProfileController extends Controller
{
    /**
     * Show the form for editing the user's profile information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function edit(Request $request)
    {
        // Pass the authenticated user to the view
        return view('settings.profile', [
            'user' => $request->user(),
        ]); // Placeholder, view needs creation/update
    }

    /**
     * Update the user's profile information.
     *
     * @param  \Illuminate\Http\Request  $request // We'll likely create a FormRequest later
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = $request->user();

        // 1. Validate the request data
        // Note: Using validate() handles throwing ValidationException automatically
        // which returns JSON errors for AJAX requests by default.
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id), // Use Rule::unique
            ],
        ]);

        // 2. Fill user model with validated data
        $user->fill($validated);

        // 3. Check if email was changed and reset verification if needed
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // 4. Save the user model
        $user->save();

        // 5. Handle response based on request type
        if ($request->expectsJson()) {
            // Return JSON response for AJAX requests
            return response()->json([
                'message' => __('Profile updated successfully.'),
                'user' => $user->fresh(), // Return updated user data if needed by frontend
            ]);
        }

        // Redirect back with success status for standard form submissions
        return redirect()->route('settings.profile')->with('status', 'profile-updated');
    }
}
