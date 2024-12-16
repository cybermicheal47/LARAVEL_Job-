<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

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
            'avatar' => 'nullable | image | mimes:jpeg,jpg,png | max:2048',
        ]);

        //update User Info
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        logger('Update function called');


        //handle file upload
        if ($request->hasFile('avatar')) {

            $file = $request->file('avatar');

            // Debugging: Check file details
            logger($file->getClientOriginalName());
            logger($file->getMimeType());
            logger($file->getSize());

            //delete old file first
            if($user->avatar){
                Storage::delete('public/' . $user->avatar);
            }

            // store new one

            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }
        $user->save();





        // Redirect back to the dashboard page with a success message
        return redirect()->route('dashboard')->with('success', 'User info updated successfully!');

    }

}
