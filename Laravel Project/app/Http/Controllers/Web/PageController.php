<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Job;
use App\Models\Training;
use App\Models\User;

class PageController extends Controller
{
    public function home()
    {
        $stats = [
            'jobs'         => \App\Models\Job::count(),
            'trainings'    => \App\Models\Training::count(),
            'users'        => \App\Models\User::where('role', 'user')->count(),
            'applications' => DB::table('job_applications')->count(),
            'districts'    => 22,
        ];
        $latestJobs = Job::where('is_active', true)->orderByDesc('posted_on')->limit(6)->get();
        return view('home', compact('stats', 'latestJobs'));
    }

    public function about()
    {
        $stats = [
            'users'        => \App\Models\User::where('role', 'user')->count(),
            'jobs'         => \App\Models\Job::count(),
            'trainings'    => \App\Models\Training::count(),
            'applications' => DB::table('job_applications')->count(),
        ];
        return view('about', compact('stats'));
    }
    public function contact() { return view('contact'); }

    // ── Authenticated user pages ──────────────────────────────────────────

    public function applications()
    {
        $apps = DB::table('job_applications')
            ->join('job_listings', 'job_applications.job_id', '=', 'job_listings.id')
            ->where('job_applications.user_id', Auth::id())
            ->select('job_applications.*', 'job_listings.title as job_title', 'job_listings.department', 'job_listings.location', 'job_listings.type')
            ->orderByDesc('job_applications.created_at')
            ->get();
        $applications = $apps;
        return view('applications', compact('applications'));
    }

    public function enrollments()
    {
        $enrollments = DB::table('training_user')
            ->join('trainings', 'training_user.training_id', '=', 'trainings.id')
            ->where('training_user.user_id', Auth::id())
            ->select('training_user.*', 'trainings.title as training_title', 'trainings.provider', 'trainings.duration', 'trainings.category', 'trainings.certificate_type', 'trainings.start_date', 'trainings.end_date')
            ->orderByDesc('training_user.enrolled_at')
            ->get();
        return view('enrollments', compact('enrollments'));
    }

    public function savedJobs()
    {
        $jobs = DB::table('saved_jobs')
            ->join('job_listings', 'saved_jobs.job_id', '=', 'job_listings.id')
            ->where('saved_jobs.user_id', Auth::id())
            ->select('job_listings.*', 'saved_jobs.saved_at')
            ->orderByDesc('saved_jobs.saved_at')
            ->get();
        $savedJobs = $jobs;
        return view('saved-jobs', compact('savedJobs'));
    }

    public function notifications()
    {
        // Fetch first (preserving is_read state), then mark as read
        $notifications = DB::table('notifications')
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->paginate(20);
        $unreadCount = DB::table('notifications')->where('user_id', Auth::id())->where('is_read', false)->count();
        $totalCount  = DB::table('notifications')->where('user_id', Auth::id())->count();
        DB::table('notifications')->where('user_id', Auth::id())->where('is_read', false)->update(['is_read' => true]);
        return view('notifications', compact('notifications', 'unreadCount', 'totalCount'));
    }

    public function resume()
    {
        $resume = DB::table('resumes')->where('user_id', Auth::id())->first();
        return view('resume', compact('resume'));
    }

    public function saveResume(Request $request)
    {
        $request->validate([
            // Personal info (saved to users table)
            'father_name'    => 'nullable|string|max:200',
            'dob'            => 'nullable|string|max:20',
            'gender'         => 'nullable|string|in:Male,Female,Other,Prefer not to say',
            'category'       => 'nullable|string|in:General,SC,ST,BC,OBC,EWS,Ex-Serviceman,PWD',
            'phone'          => 'nullable|string|max:15',
            'district'       => 'nullable|string|max:100',
            'address'        => 'nullable|string|max:500',
            // Resume fields (saved to resumes table)
            'objective'      => 'nullable|string|max:1000',
            'skills'         => 'nullable|string|max:2000',
            'education'      => 'nullable|string|max:3000',
            'experience'     => 'nullable|string|max:3000',
            'certifications' => 'nullable|string|max:2000',
            'languages'      => 'nullable|string|max:500',
        ]);

        // Update personal info in users table
        DB::table('users')->where('id', Auth::id())->update([
            'father_name' => $request->father_name,
            'dob'         => $request->dob,
            'gender'      => $request->gender,
            'category'    => $request->category,
            'phone'       => $request->phone,
            'district'    => $request->district,
            'address'     => $request->address,
        ]);

        // Upsert resume record
        $resumeData = [
            'objective'      => $request->objective,
            'skills'         => $request->skills,
            'education'      => $request->education,
            'experience'     => $request->experience,
            'certifications' => $request->certifications,
            'languages'      => $request->languages,
            'updated_at'     => now(),
        ];

        $existing = DB::table('resumes')->where('user_id', Auth::id())->first();
        if ($existing) {
            DB::table('resumes')->where('user_id', Auth::id())->update($resumeData);
            \App\Models\Notification::create([
                'user_id' => Auth::id(),
                'title'   => 'Resume Updated',
                'message' => 'Your resume has been updated successfully. Keep it fresh to improve your job match score.',
                'type'    => 'info',
                'is_read' => false,
            ]);
        } else {
            $resumeData['user_id']    = Auth::id();
            $resumeData['created_at'] = now();
            DB::table('resumes')->insert($resumeData);
            \App\Models\Notification::create([
                'user_id' => Auth::id(),
                'title'   => 'Resume Created',
                'message' => 'Your resume has been created successfully. Employers can now find your profile.',
                'type'    => 'info',
                'is_read' => false,
            ]);
        }

        return back()->with('success', 'Resume saved successfully!');
    }

    public function counselling()
    {
        $sessions = DB::table('counselling_requests')
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();
        return view('counselling', compact('sessions'));
    }

    public function bookCounselling(Request $request)
    {
        $request->validate([
            'topic'            => 'required|string|max:255',
            'preferred_date'   => 'required|date|after:today',
            'preferred_time'   => 'required|string',
            'notes'            => 'nullable|string|max:1000',
        ]);

        DB::table('counselling_requests')->insert([
            'user_id'          => Auth::id(),
            'topic'            => $request->topic,
            'preferred_date'   => $request->preferred_date,
            'preferred_time'   => $request->preferred_time,
            'notes'            => $request->notes,
            'status'           => 'pending',
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);

        \App\Models\Notification::create([
            'user_id' => Auth::id(),
            'title'   => 'Counselling Session Booked',
            'message' => "Your career counselling session on \"{$request->topic}\" has been booked for {$request->preferred_date} at {$request->preferred_time}. Our advisor will contact you shortly.",
            'type'    => 'info',
            'is_read' => false,
        ]);

        return back()->with('success', 'Counselling session booked! You will be contacted shortly.');
    }
}
