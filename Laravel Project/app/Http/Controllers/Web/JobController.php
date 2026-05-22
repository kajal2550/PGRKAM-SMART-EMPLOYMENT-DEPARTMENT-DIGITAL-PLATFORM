<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $query = Job::where('is_active', true);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('title', 'like', "%$s%")
                  ->orWhere('department', 'like', "%$s%")
                  ->orWhere('location', 'like', "%$s%");
            });
        }
        if ($request->filled('type') && $request->type !== 'All') {
            $query->where('type', $request->type);
        }
        if ($request->filled('location') && $request->location !== 'All') {
            $query->where('location', $request->location);
        }

        $jobs = $query->orderByDesc('posted_on')->get();

        // User's applied & saved job IDs
        $applied = $saved = [];
        if (Auth::check()) {
            $applied = DB::table('job_applications')->where('user_id', Auth::id())->pluck('job_id')->toArray();
            $saved   = DB::table('saved_jobs')->where('user_id', Auth::id())->pluck('job_id')->toArray();
        }

        $types     = ['All', 'Government', 'Private', 'Contract', 'Internship'];
        $locations = array_merge(['All'], Job::where('is_active', true)->distinct()->pluck('location')->filter()->values()->toArray());

        return view('jobs.index', compact('jobs', 'applied', 'saved', 'types', 'locations'));
    }

    public function showApply($id)
    {
        $job = Job::findOrFail($id);

        $isApplied = DB::table('job_applications')
            ->where('user_id', Auth::id())
            ->where('job_id', $id)
            ->exists();

        return view('jobs.apply', compact('job', 'isApplied'));
    }

    public function apply(Request $request, $id)
    {
        $job = Job::findOrFail($id);

        $request->validate([
            'applicant_name' => 'required|string|max:255',
            'phone'          => 'required|string|max:15',
            'experience'     => 'required|string',
            'qualification'  => 'required|string',
            'cover_letter'   => 'nullable|string|max:2000',
            'cv'             => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Prevent duplicate
        $exists = DB::table('job_applications')
            ->where('user_id', Auth::id())
            ->where('job_id', $id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'You have already applied for this job.');
        }

        $cvPath = null;
        if ($request->hasFile('cv')) {
            $cvPath = $request->file('cv')->store('cvs', 'public');
        }

        $ref = 'PGR-' . strtoupper(substr(md5(Auth::id() . $id . time()), 0, 8));

        DB::table('job_applications')->insert([
            'user_id'         => Auth::id(),
            'job_id'          => $id,
            'applicant_name'  => $request->applicant_name,
            'applicant_email' => Auth::user()->email,
            'phone'           => $request->phone,
            'experience'      => $request->experience,
            'qualification'   => $request->qualification,
            'cover_letter'    => $request->cover_letter,
            'cv_path'         => $cvPath,
            'status'          => 'pending',
            'application_ref' => $ref,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        \App\Models\Notification::create([
            'user_id' => Auth::id(),
            'title'   => 'Application Submitted',
            'message' => "Your application for \"{$job->title}\" has been submitted successfully. Reference: {$ref}. We will notify you of any updates.",
            'type'    => 'job',
            'is_read' => false,
        ]);

        return back()->with('success', "Application submitted! Your reference: $ref");
    }

    public function saveToggle(Request $request, $id)
    {
        $job    = Job::findOrFail($id);
        $exists = DB::table('saved_jobs')->where('user_id', Auth::id())->where('job_id', $id)->exists();
        if ($exists) {
            DB::table('saved_jobs')->where('user_id', Auth::id())->where('job_id', $id)->delete();
            return back()->with('success', 'Job removed from saved list.');
        } else {
            DB::table('saved_jobs')->insert(['user_id' => Auth::id(), 'job_id' => $id, 'saved_at' => now()]);
            \App\Models\Notification::create([
                'user_id' => Auth::id(),
                'title'   => 'Job Saved',
                'message' => "You saved \"{$job->title}\" to your list. You can view it anytime under Saved Jobs.",
                'type'    => 'job',
                'is_read' => false,
            ]);
            return back()->with('success', 'Job saved successfully!');
        }
    }
}
