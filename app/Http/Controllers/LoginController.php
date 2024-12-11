<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
class LoginController extends Controller
{



    //// @desc  Show Logn form
    //// @route GET /login
    public function login():View {
        return view('auth.login');
    }

    //// @desc  auth lpgin form
    //// @route Post /login
    ///

    public function authenticate(Request $request): RedirectResponse {

        $credentials = $request->validate( [

            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string'],
        ]);
        //atempt to authenticate
        if(Auth::attempt($credentials)) {
            //Regenerate session to prevent fixation attacks
            $request->session()->regenerate();
            // Redirect to intended route or home with success message
            return redirect()->intended(route('home'))->with('success', 'Login Successful!');

        }
//if auth fails , redirect back with errors
 return back()->withErrors([
     'email' => 'The provided credentials do not match our records.',

 ])->onlyInput('email');
    }



    //// @desc  Show Logn form
    //// @route GET /login
    public function logout(Request $request):RedirectResponse {
        Auth::logout();
        $request->session()->invalidate();
        return  redirect( '/');
    }

}
