<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;

class ProfileController extends Controller
{
    public function show()
    {
        $profile = Auth::user()->profile;
        return view('profile.show', compact('profile'));
    }

    public function edit()
    {
        $profile = Auth::user()->profile;
        return view('profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        $profile = Auth::user()->profile;
        $profile->first_name = $request->first_name;
        $profile->last_name = $request->last_name;
        $profile->bio = $request->bio;

        if ($request->hasFile('profile_picture')) {
            $profile->profile_picture = $request->file('profile_picture')->store('profiles');
        }

        $profile->save();

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    }
}