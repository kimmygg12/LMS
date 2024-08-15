<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Member; // Import the Member model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Import Hash facade
use Illuminate\Support\Facades\Auth; // Import Auth facade
class MemberAuthController extends Controller
{
    /**
     * Show the registration form for members.
     *
     * @return \Illuminate\View\View
     */
    public function showRegisterForm()
    {
        return view('members.register');
    }

    /**
     * Handle the member registration process.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $request->validate([
            'memberId' => 'required|string|exists:members,memberId',
            'password' => 'required|string|confirmed|min:8',
        ]);
    
        $member = Member::where('memberId', $request->memberId)->first();
    
        if ($member->password) {
            return redirect()->back()->withErrors(['memberId' => 'This Member ID has already been registered.']);
        }
    
        $member->password = Hash::make($request->password);
        $member->save();
    
        Auth::guard('member')->login($member);
    
        return redirect()->route('members.dashboard');
    }
    
    public function showLoginForm()
    {
        return view('members.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('memberId', 'password');

        if (Auth::guard('member')->attempt($credentials)) {
            return redirect()->route('members.dashboard');
        }

        return redirect()->back()->withErrors(['memberId' => 'Invalid Member ID or Password.']);
    }
    public function logout(Request $request)
    {
        Auth::guard('member')->logout();

        // return redirect()->route('member.login');
        return redirect()->route('home.student');
    }

}
