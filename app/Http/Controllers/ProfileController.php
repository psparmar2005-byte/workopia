<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function update(Request $request): RedirectResponse {
        $user = Auth::user();

        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email',
            'avatar' => 'nullable|image|mimes:png,jpg,jpeg,gif|max:2048'
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if($request->hasFile('avatar')){

            if($user->avatar){
                Storage::disk('public')->delete($user->avatar);
            }

            $avatarPath = $request->file('avatar')->store('avatars','public');
            $user->avatar = $avatarPath;
        }

        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profile info Updated!');

    }

    public function show(Request $request): View{

        $user = $request->user();

         return view('pages.profile',compact('user'));
    }
}
