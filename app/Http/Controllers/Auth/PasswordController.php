<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        // Log the attempt with user id
        Log::info('Password update attempt', ['user_id' => $request->user()->id]);
        
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        // Log successful validation
        Log::info('Password update validation passed', ['user_id' => $request->user()->id]);

        $updated = $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);
        
        // Log the result
        Log::info('Password update result', ['user_id' => $request->user()->id, 'success' => $updated]);

        return back()->with('status', 'password-updated');
    }
}
