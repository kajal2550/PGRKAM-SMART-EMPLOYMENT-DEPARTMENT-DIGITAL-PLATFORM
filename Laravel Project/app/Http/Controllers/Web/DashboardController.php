<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Training;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Redirect admin to admin dashboard
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $applications = DB::table('job_applications')
            ->join('job_listings', 'job_applications.job_id', '=', 'job_listings.id')
            ->where('job_applications.user_id', $user->id)
            ->select('job_applications.*', 'job_listings.title as job_title', 'job_listings.department', 'job_listings.location')
            ->orderByDesc('job_applications.created_at')
            ->limit(5)
            ->get();

        $enrollments = DB::table('training_user')
            ->join('trainings', 'training_user.training_id', '=', 'trainings.id')
            ->where('training_user.user_id', $user->id)
            ->select('training_user.*', 'trainings.title as training_title', 'trainings.provider', 'trainings.duration', 'trainings.category')
            ->orderByDesc('training_user.enrolled_at')
            ->limit(5)
            ->get();

        $savedJobs = DB::table('saved_jobs')
            ->join('job_listings', 'saved_jobs.job_id', '=', 'job_listings.id')
            ->where('saved_jobs.user_id', $user->id)
            ->select('job_listings.*', 'saved_jobs.saved_at')
            ->orderByDesc('saved_jobs.saved_at')
            ->limit(4)
            ->get();

        $notifications = DB::table('notifications')
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $stats = [
            'applications' => DB::table('job_applications')->where('user_id', $user->id)->count(),
            'enrollments'  => DB::table('training_user')->where('user_id', $user->id)->count(),
            'savedJobs'    => DB::table('saved_jobs')->where('user_id', $user->id)->count(),
            'saved'        => DB::table('saved_jobs')->where('user_id', $user->id)->count(),
            'unread_notif' => DB::table('notifications')->where('user_id', $user->id)->where('is_read', false)->count(),
        ];

        $recentJobs = Job::where('is_active', true)->orderByDesc('posted_on')->limit(5)->get();

        return view('dashboard', compact('user', 'applications', 'enrollments', 'savedJobs', 'notifications', 'stats', 'recentJobs'));
    }
}
