<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $bookmarks = $user->bookmarkedJobs()->orderBy('job_user_bookmarks.created_at', 'desc')->paginate(9);

        return view('jobs.bookmarked')->with('bookmarks', $bookmarks);
    }

    public function store(Job $job)
    {
        $user = Auth::user();
        if ($user->bookmarkedJobs()->where('job_id', $job->id)->exists()) {
            return back()->with('error', 'Job is already bookmarked.');
        }

        $user->bookmarkedJobs()->attach($job->id);

        return back()->with('success', 'Job bookmarked!');
    }

    public function destroy(Job $job)
    {
        $user = Auth::user();
        if (! $user->bookmarkedJobs()->where('job_id', $job->id)->exists()) {
            return back()->with('status', 'Job is not bookmarked.');
        }

        $user->bookmarkedJobs()->detach($job->id);

        return back()->with('success', 'Bookmark removed!');
    }
}
