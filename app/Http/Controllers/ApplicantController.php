<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Applicant;
use Illuminate\Http\RedirectResponse;
class ApplicantController extends Controller
{
     // @desc   Store a new job application
    //    // @route  POST /jobs/{job}/apply

    public function store(Request $request, Job $job): RedirectResponse {
//validate incoming data
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'contact_phone' => 'string|max:20',
            'contact_email' => 'required|email',
            'message' => 'string',
            'location' => 'string|max:255',
            'resume' => 'required|file|mimes:pdf|max:2048',
        ]);


        // Handle file upload
        if ($request->hasFile('resume')) {
            $path = $request->file('resume')->store('resume');
            $validatedData['resume_path'] = $path; // Ensure the correct column name

        } else {
            dd('Resume file is missing or invalid!');
        }

        // Store the application
            $application = new Applicant($validatedData);
            $application->job_id = $job->id;
            $application->user_id = auth()->id();
            $application->save();


        return redirect()->back()->with('success', 'Your application has been submitted!');


    }


}

