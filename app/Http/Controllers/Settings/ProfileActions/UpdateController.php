<?php

namespace App\Http\Controllers\Settings\ProfileActions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\UpdateProfileRequest;

// Use the created FormRequest
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    /**
     * Handle the incoming request.
     * Update the user's profile information.
     */
    public function __invoke(UpdateProfileRequest $request): RedirectResponse|JsonResponse
    {
        $user = $request->user();

        // Validation is handled by UpdateProfileRequest
        $validated = $request->validated();

        // Fill user model with validated data
        $user->fill($validated);

        // Check if email was changed and reset verification if needed
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Save the user model
        $user->save();

        // Handle response based on request type
        if ($request->expectsJson()) {
            // Return JSON response for AJAX requests
            return response()->json([
                'message' => __('Profile updated successfully.'),
                'user' => $user->fresh(), // Return updated user data if needed for client-side updates
            ]);
        }

        // Redirect back with success status for standard form submissions
        return redirect()->route('settings.profile')->with('status', 'profile-updated');
    }
}
