<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        // Log that the profile page is being viewed
        Log::info('User viewing profile page', [
            'user_id' => $request->user()->id,
            'is_admin' => $request->user()->is_admin
        ]);
        
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        try {
            // Get validated data
            $validated = $request->validated();
            
            // Log the validated data for debugging
            Log::info('Profile update validated data:', $validated);
            
            // Dump all the user attributes before filling
            Log::debug('User attributes before filling:', [
                'user_id' => $request->user()->id,
                'attributes' => $request->user()->getAttributes()
            ]);
            
            // Fill user with validated data
            $request->user()->fill($validated);
            
            // Check what attributes are dirty (changed)
            Log::info('Dirty attributes:', [
                'user_id' => $request->user()->id,
                'dirty' => $request->user()->getDirty()
            ]);

            if ($request->user()->isDirty('email')) {
                $request->user()->email_verified_at = null;
            }

            // Save the user and log the result
            $saved = $request->user()->save();
            Log::info('Profile update result:', [
                'saved' => $saved, 
                'user_id' => $request->user()->id,
                'updated_attributes' => $request->user()->getChanges()
            ]);

            return Redirect::route('profile.edit')->with('status', 'profile-updated');
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Error updating profile:', [
                'user_id' => $request->user()->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return Redirect::route('profile.edit')
                ->withErrors(['update' => 'An error occurred while updating your profile. Please try again.'])
                ->withInput();
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        try {
            $request->validateWithBag('userDeletion', [
                'password' => ['required', 'current_password'],
            ]);

            $user = $request->user();
            
            // Log the account deletion attempt
            Log::warning('User account deletion initiated', [
                'user_id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'is_admin' => $user->is_admin
            ]);

            Auth::logout();

            $deleted = $user->delete();
            
            // Log the deletion result
            Log::warning('User account deletion completed', [
                'success' => $deleted,
                'user_id' => $user->id
            ]);

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return Redirect::to('/');
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Error deleting user account:', [
                'user_id' => $request->user()->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->withErrors(['userDeletion' => 'An error occurred while deleting your account. Please try again.']);
        }
    }
}
