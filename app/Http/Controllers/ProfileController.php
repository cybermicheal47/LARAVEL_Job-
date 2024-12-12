<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // @desc update Profile
    //@route  PUT/profile
    public function update(Request $request)
    {
        //get the authenticated user
        $user = Auth::user();
 //Validate Data
        $validatedData = $request->validate([
            'name' => 'required | string',
            'email' => 'required | string |email',
        ]);

        //update User Info
        $user ->update($validatedData);

        // Redirect back to the dashboard page with a success message
        return redirect()->route('dashboard')->with('success', 'User info updated successfully!');

    }

}
