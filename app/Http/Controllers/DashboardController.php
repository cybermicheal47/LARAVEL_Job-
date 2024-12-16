<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use illuminate\View\View;

class DashboardController extends Controller
{
    //

    public function index ():view {
      //Get Logged User

        $user = Auth::user();
        //Get user listing

        $jobs = Job::where('user_id', $user->id)->with('applicants')->get();


        return view('dashboard/index', compact('user','jobs'));
    }

}
