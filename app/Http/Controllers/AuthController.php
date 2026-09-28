<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard')->with('success', 'Welcome back to the Atelier Dashboard.');
            }

            return redirect()->intended(route('dashboard'))->with('success', 'Welcome back to ChérieRent.');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'role' => 'customer',
            'avatar' => 'https://api.dicebear.com/7.x/adventurer/svg?seed='.urlencode($validated['name']),
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Your ChérieRent account has been created successfully.');
    }

    public function quickDemoLogin($role)
    {
        $email = match ($role) {
            'admin' => 'admin@cherierent.com',
            default => 'user@cherierent.com',
        };

        $user = User::where('email', $email)->first();
        if ($user) {
            Auth::login($user);
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard')->with('success', 'Authenticated as Atelier Administrator.');
            }

            return redirect()->route('dashboard')->with('success', 'Authenticated as Client Demo.');
        }

        return redirect()->route('login')->with('error', 'Demo account not found.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'You have been signed out.');
    }
}
