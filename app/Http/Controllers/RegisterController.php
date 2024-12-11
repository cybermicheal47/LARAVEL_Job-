<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisterController extends Controller
{
    //// @desc  Show register form
    //// @route GET /register
    public function register():View {
        return view('auth.register');
    }

    //// @desc  Show register form
    //// @route GET /register
    public function store(Request $request):RedirectResponse {
        $validateData = $request->validate( [
          'name' => ['required', 'string', 'max:255'],
          'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
          'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        //hashassword

        $validateData['password']=Hash::make($validateData['password']);

        //create user
        $user = User::create($validateData);

        return redirect()->route('login')->with('success', 'Registration Successful!');
    }
}
