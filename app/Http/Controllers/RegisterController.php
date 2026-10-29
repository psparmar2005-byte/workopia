<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(): View
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {

        $ValidatedData = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $ValidatedData['password'] = Hash::make($ValidatedData['password']);

        $user = User::create($ValidatedData);

        return redirect()->route('login')->with('success','You are registered successfully and can login now!');
    }


}
