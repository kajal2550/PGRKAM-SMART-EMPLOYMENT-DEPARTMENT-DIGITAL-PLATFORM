<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'     => 'required|string|max:255',
            'phone'    => 'nullable|string|max:15',
            'district' => 'nullable|string|max:100',
            'dob'      => 'nullable|date',
            'gender'   => 'nullable|in:male,female,other',
        ]);

        $user->update($request->only('name', 'phone', 'district', 'dob', 'gender'));

        \App\Models\Notification::create([
            'user_id' => $user->id,
            'title'   => 'Profile Updated',
            'message' => 'Your profile information has been updated successfully.',
            'type'    => 'info',
            'is_read' => false,
        ]);

        return back()->with('success', 'Profile updated successfully!');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password'     => 'required',
            'password'             => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        Auth::user()->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password changed successfully!');
    }
}
