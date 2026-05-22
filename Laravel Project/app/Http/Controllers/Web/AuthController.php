<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) return redirect()->route('dashboard');
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'))->with('success', 'Welcome back, ' . Auth::user()->name . '!');
        }

        return back()->withErrors(['credentials' => 'Invalid email or password.'])->withInput($request->only('email'));
    }

    public function showRegister()
    {
        if (Auth::check()) return redirect()->route('dashboard');
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users',
            'phone'                 => 'nullable|string|max:15',
            'password'              => ['required', 'confirmed', Password::min(8)],
            'agree'                 => 'accepted',
        ], [
            'agree.accepted' => 'You must agree to the Terms of Service and Privacy Policy.',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'district' => $request->district,
            'password' => Hash::make($request->password),
            'role'     => 'user',
        ]);

        Notification::create([
            'user_id' => $user->id,
            'title'   => 'Welcome to PGRKAM!',
            'message' => 'Your account has been created. Start exploring government and private job opportunities across Punjab.',
            'type'    => 'info',
            'link'    => '/dashboard',
            'is_read' => false,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('success', 'Account created successfully! Welcome to PGRKAM.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'Logged out successfully.');
    }
}
