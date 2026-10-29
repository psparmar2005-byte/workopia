<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Job;
use Brick\Math\BigInteger;
use Illuminate\Http\Request;
use App\Mail\JobApplied;
use Illuminate\Support\Facades\Mail;

class ApplicantController extends Controller
{
    public function store(Request $request,Job $job){


    if(Applicant::where('job_id',$job->id)->where('user_id',auth()->id())->exists()){
        return redirect()->back()->with('error','You can not apply to the same job multiple times.');
    }


            $validatedData = $request->validate([
                'full_name' => 'required|string',
                'contact_phone' => 'nullable|string',
                'contact_email' => 'required|email|string',
                'message' => 'nullable|string',
                'location' => 'nullable|string',
                'resume' => 'required|file|mimes:pdf|max:2048',
            ]);

            //handle resume upload 
            if($request->hasFile('resume')){
                $path = $request->file('resume')->store('resumes','public');
                $validatedData['resume_path'] = $path;
            }

            $application = new Applicant($validatedData);
            $application->job_id = $job->id;
            $application->user_id = auth()->id();
            $application->save();

            //send email
            Mail::to($job->user->email)->send(new JobApplied($application,$job));

            return redirect()->back()->with('success','Application submitted successfully!');
    }

    public function destroy($id){
        $applicant = Applicant::findOrFail($id);
        $applicant->delete();

        return redirect()->route('dashboard')->with('success','Applicant deleted successfully!');
    }

}
