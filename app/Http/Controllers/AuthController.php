<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLoginForm(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        if (Auth::check()) {
            return redirect()->route('home'); // Redirect to home if already logged in
        }

        return view('auth.login');
    }

    public function showRegistrationForm(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('auth.register');
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $this->validator($request->all())->validate();

        $admin = $this->create($request->all());

        // Optionally, you can auto-login the admin after registration
        // Auth::login($admin);

        return redirect()->route('login')->with('success', 'User registration successful.');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function login(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            // Check the role and approval status of the authenticated user
            if (Auth::user()->role === 'admin') {
                return redirect()->route('home'); // Redirect to vendors approval for admin
            } elseif (Auth::user()->role === 'vendor') {
                // Check if the vendor is approved
                if (Auth::user()->vendor->approved == 1) {
                    return redirect()->route('products.index'); // Redirect to product index for approved vendor
                } else {
                    Auth::logout(); // Log out the user if not approved
                    return redirect()->route('login')->with('error', 'Your account is not approved yet.');
                }
            }
        }

        return redirect()->route('login')->with('error', 'The provided credentials do not match our records.');
    }

    public function logout(): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        Auth::logout();
        return redirect('/login');
    }
}
