<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(Request $request): View
    {
        $user = $request->user()->load('profile');

        return view('profile.show', ['user' => $user]);
    }

    public function edit(Request $request): View
    {
        $user = $request->user()->load('profile');

        return view('profile.edit', ['user' => $user]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();

        // --- Update core `users` table fields ---
        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // Force re-verification if the email address actually changed
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // --- Update the linked `profiles` table record ---
        $profileData = [
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'district' => $validated['district'] ?? null,
            'profession' => $validated['profession'] ?? null,
        ];

        // Handle an optional new profile photo upload
        if ($request->hasFile('photo')) {
            // Remove the old photo from storage before saving the new one
            if ($user->profile && $user->profile->photo) {
                Storage::disk('public')->delete($user->profile->photo);
            }

            $profileData['photo'] = $request->file('photo')->store('profile-photos', 'public');
        }

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $profileData
        );

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        if ($user->profile && $user->profile->photo) {
            Storage::disk('public')->delete($user->profile->photo);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
