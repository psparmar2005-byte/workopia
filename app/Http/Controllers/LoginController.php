<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login() : View {
        return view('auth.login');
    }

    public function authenticate(Request $request): RedirectResponse
    {

        $Credentials = $request->validate([
            'email' => 'required|string|email|max:100',
            'password' => 'required|string',
        ]);

        if(Auth::attempt($Credentials))  {
            $request->session()->regenerate();

            return redirect()->intended(route('home'))->with('success','You are Logged in Successfully!');
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
