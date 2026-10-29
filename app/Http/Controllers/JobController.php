<?php

namespace App\Http\Controllers;

use App\Models\Job;
use GrahamCampbell\ResultType\Success;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class JobController extends Controller
{

    use AuthorizesRequests; 

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = Job::latest()->paginate(9);

        return view('jobs.index')->with('jobs', $jobs);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

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
            'zipcode' => 'nullable|string',
            'contact_email' => 'required|string',
            'contact_phone' => 'nullable|string',
            'company_name' => 'required|string',
            'company_description' => 'nullable|string',
            'company_website' => 'nullable|url',
            'company_logo' => 'nullable|image|mimes:png,jpeg,jpg,gif|max:2048',
        ]);


        $validatedData['user_id'] = auth()->user()->id; 

        if($request->hasFile('company_logo')) {
            $path= $request->file('company_logo')->store('logos','public');
            $validatedData['company_logo']=$path;
        }
        Job::create($validatedData);

        return redirect()->route('jobs.index')->with('success' , 'Job created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job): View
    {
        return view('jobs.show')->with('job', $job);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job)
    {

        //check if user is authorized
        $this->authorize('update', $job);
        
        return view('jobs.edit')->with('job', $job);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Job $job)
    {

        //check if user is authorized
        $this->authorize('update',$job);

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
            'zipcode' => 'nullable|string',
            'contact_email' => 'required|string',
            'contact_phone' => 'nullable|string',
            'company_name' => 'required|string',
            'company_description' => 'nullable|string',
            'company_website' => 'nullable|url',
            'company_logo' => 'nullable|image|mimes:png,jpeg,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('company_logo'))  
        {
            Storage::disk('public')->delete($job->company_logo);
            $path = $request->file('company_logo')->store('logos', 'public');
            $validatedData['company_logo'] = $path;
        }

        $job->update($validatedData);

        return redirect()->route('jobs.index')->with('success', 'Job Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job)
    {
        //check if user is authorized
        $this->authorize('delete', $job);

        if($job->company_logo){
            Storage::disk('public')->delete($job->company_logo);
        }
        
        $job->delete();

        if(request()->query('from') == 'dashboard'){
            return redirect()->route('dashboard')->with('success', 'Job Deleted successfully!');
        }

        return redirect()->route('jobs.index')->with('success', 'Job Deleted successfully!');
    }

    public function search(Request $request){
        $keywords = strtolower($request->input('keywords'));
        $location = strtolower($request->input('location'));

        $query = Job::query();

        if($keywords){
            $query->where(function ($q) use ($keywords) {
                    $q->whereRaw('LOWER(title) like ?' , ['%' . $keywords . '%'])
                      ->orWhereRaw('LOWER(description) like ?', ['%' . $keywords . '%'])
                      ->orWhereRaw('LOWER(tags) like ?', ['%' . $keywords . '%']);
            });
        }

        if ($location) {
            $query->where(function ($q) use ($location) {
                $q->whereRaw('LOWER(address) like ?', ['%' . $location . '%'])
                    ->orWhereRaw('LOWER(city) like ?', ['%' . $location . '%'])
                    ->orWhereRaw('LOWER(state) like ?', ['%' . $location . '%'])
                    ->orWhereRaw('LOWER(zipcode) like ?', ['%' . $location . '%']);
            });
        }

        $jobs = $query->paginate(9);

        return view('jobs.index')->with('jobs',$jobs);

    }
}
