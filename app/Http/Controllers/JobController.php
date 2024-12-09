<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;



class JobController extends Controller
{
    // @desc   Show all jobs
    // @route  GET /jobs
    public function index()
    {
    $jobs = Job::all();


        return view('jobs/index', compact('jobs'));
    }

    // @desc   Show create job form
    // @route  GET /jobs/create
    public function create()
    {
        return view('jobs.create');
    }

    // @desc   Store a new job
    // @route  POST /jobs
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'salary' => 'required|integer',
            'tags' => 'nullable|string',
            'job_type' => 'required|string',
            'remote' => 'required|boolean',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zipcode' => 'required|string',
            'contact_email' => 'required|email',
            'contact_phone' => 'nullable|string',
            'company_name' => 'required|string',
            'company_description' => 'nullable|string',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'company_website' => 'nullable|url',
        ]);

        $validateData['user_id'] = 1;

        if($request->hasFile('company_logo')) {
            //store the file and path
            $path = $request->file('company_logo')->store('logos','public');

            //add path too ValidateData
            $validateData['company_logo'] = $path;
        }


        // Create a new job listing with the validated data
        Job::create($validateData);


        return redirect()->route('jobs.index')->with('success', "Job Listed succesfully");
    }

    // @desc   Show a single job
    // @route  GET /jobs/{id}
    public function show(Job $job)
    {
        return view('jobs.show', compact('job'));
    }

    // @desc   Show the form for editing a job
    // @route  GET /jobs/{id}/edit
    public function edit(string $id): View
    {
        // Fetch the current job listing
        $job = Job::find($id);
        return view('jobs.edit')->with('job', $job);
    }

    // @desc   Update a job
    // @route  PUT /jobs/{id}
    public function update(Request $request,  Job $job): RedirectResponse
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'salary' => 'required|integer',
            'tags' => 'nullable|string',
            'job_type' => 'required|string',
            'remote' => 'required|boolean',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zipcode' => 'required|string',
            'contact_email' => 'required|email',
            'contact_phone' => 'nullable|string',
            'company_name' => 'required|string|max:255',
            'company_description' => 'nullable|string',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'company_website' => 'nullable|url',
        ]);


        // Check if a file was uploaded
        if ($request->hasFile('company_logo')) {
            // Delete the old company logo from storage
            if ($job->company_logo) {
                Storage::delete('public/logos/' . basename($job->company_logo));
            }
            // Store the file and get the path
            $path = $request->file('company_logo')->store('logos', 'public');

            // Add the path to the validated data array
            $validatedData['company_logo'] = $path;
        }

        // Update with the validated data
        $job->update($validatedData);

        return redirect()->route('jobs.index')->with('success', 'Job listing updated successfully!');
    }
    // @desc  Delete a job
    // @route DELETE /jobs/{id}
    public function destroy(Job $job)
    {
//        if logo then delete

        if($job->company_logo){
Storage::delete('public/logos/' . $job->company_logo);
        }
  $job->delete();
        return redirect()->route('jobs.index')->with('success', 'deleted Successfully');
    }
}
