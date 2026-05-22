<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Training;
use App\Models\Service;
use App\Models\User;
use App\Models\CounsellingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // ── Dashboard ─────────────────────────────────────────────────────────────
    public function dashboard()
    {
        $stats = [
            'total_users'         => User::where('role', 'user')->count(),
            'total_jobs'          => Job::count(),
            'active_jobs'         => Job::where('is_active', true)->count(),
            'total_trainings'     => Training::count(),
            'total_applications'  => DB::table('job_applications')->count(),
            'total_enrollments'   => DB::table('training_user')->count(),
            'pending_counselling' => CounsellingRequest::where('status', 'pending')->count(),
            'total_counselling'   => CounsellingRequest::count(),
        ];

        $recentUsers = User::where('role', 'user')->orderByDesc('created_at')->limit(5)->get();
        $recentApps  = DB::table('job_applications')
            ->join('job_listings', 'job_applications.job_id', '=', 'job_listings.id')
            ->join('users', 'job_applications.user_id', '=', 'users.id')
            ->select('job_applications.*', 'job_listings.title as job_title', 'users.name as user_name')
            ->orderByDesc('job_applications.created_at')
            ->limit(5)->get();

        $monthlyUsers = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')->orderBy('month')->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentApps', 'monthlyUsers'));
    }

    // ── Users ─────────────────────────────────────────────────────────────────
    public function users(Request $request)
    {
        $query = User::where('role', 'user');
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('name', 'like', "%$s%")->orWhere('email', 'like', "%$s%"));
        }
        $users = $query->orderByDesc('created_at')->paginate(15);
        return view('admin.users', compact('users'));
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        if ($user->role === 'admin') return back()->with('error', 'Cannot delete admin account.');
        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }

    // ── Jobs ──────────────────────────────────────────────────────────────────
    public function jobs(Request $request)
    {
        $query = Job::query();
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('title', 'like', "%$s%")->orWhere('department', 'like', "%$s%"));
        }
        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }
        $jobs = $query->orderByDesc('created_at')->paginate(15);
        return view('admin.jobs', compact('jobs'));
    }

    public function createJob()
    {
        return view('admin.job-form', ['job' => null]);
    }

    public function storeJob(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'department'  => 'required|string|max:255',
            'location'    => 'required|string|max:100',
            'type'        => 'required|in:government,private,contract,internship',
            'salary_range'=> 'nullable|string|max:100',
            'vacancies'   => 'nullable|integer|min:1',
            'description' => 'nullable|string',
            'application_deadline' => 'nullable|date',
        ]);

        Job::create([
            'title'                => $request->title,
            'department'           => $request->department,
            'location'             => $request->location,
            'type'                 => $request->type,
            'salary_range'         => $request->salary_range,
            'vacancies'            => $request->vacancies ?? 1,
            'description'          => $request->description,
            'application_deadline' => $request->application_deadline,
            'posted_on'            => now()->toDateString(),
            'is_active'            => $request->has('is_active'),
        ]);

        return redirect()->route('admin.jobs')->with('success', 'Job created successfully!');
    }

    public function editJob($id)
    {
        $job = Job::findOrFail($id);
        return view('admin.job-form', compact('job'));
    }

    public function updateJob(Request $request, $id)
    {
        $job = Job::findOrFail($id);
        $request->validate([
            'title'      => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'location'   => 'required|string|max:100',
            'type'       => 'required|in:government,private,contract,internship',
        ]);

        $job->update([
            'title'                => $request->title,
            'department'           => $request->department,
            'location'             => $request->location,
            'type'                 => $request->type,
            'salary_range'         => $request->salary_range,
            'vacancies'            => $request->vacancies ?? 1,
            'description'          => $request->description,
            'application_deadline' => $request->application_deadline,
            'is_active'            => $request->has('is_active'),
        ]);

        return redirect()->route('admin.jobs')->with('success', 'Job updated successfully!');
    }

    public function deleteJob($id)
    {
        Job::findOrFail($id)->delete();
        return back()->with('success', 'Job deleted.');
    }

    // ── Trainings ─────────────────────────────────────────────────────────────
    public function trainings(Request $request)
    {
        $query = Training::query();
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('title', 'like', "%$s%")->orWhere('category', 'like', "%$s%"));
        }
        $trainings = $query->orderByDesc('created_at')->paginate(15);
        return view('admin.trainings', compact('trainings'));
    }

    public function deleteTraining($id)
    {
        Training::findOrFail($id)->delete();
        return back()->with('success', 'Training deleted.');
    }

    // ── Counselling ───────────────────────────────────────────────────────────
    public function counselling(Request $request)
    {
        $query = CounsellingRequest::with('user');
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        $sessions = $query->orderByDesc('created_at')->paginate(15);
        return view('admin.counselling', compact('sessions'));
    }

    public function updateCounselling(Request $request, $id)
    {
        $session = CounsellingRequest::findOrFail($id);
        $session->update(['status' => $request->status]);
        return back()->with('success', 'Session status updated.');
    }

    // ── Applications ──────────────────────────────────────────────────────────
    public function applications(Request $request)
    {
        $query = DB::table('job_applications')
            ->join('job_listings', 'job_applications.job_id', '=', 'job_listings.id')
            ->join('users', 'job_applications.user_id', '=', 'users.id')
            ->select('job_applications.*', 'job_listings.title as job_title', 'job_listings.type as job_type', 'users.name as user_name', 'users.email as user_email');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('users.name', 'like', "%$s%")->orWhere('job_listings.title', 'like', "%$s%"));
        }
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('job_applications.status', $request->status);
        }

        $applications = $query->orderByDesc('job_applications.created_at')->paginate(15);
        return view('admin.applications', compact('applications'));
    }

    public function updateApplication(Request $request, $id)
    {
        $app = DB::table('job_applications')->where('id', $id)->first();
        if (!$app) return back()->with('error', 'Application not found.');

        $newStatus = $request->status;
        DB::table('job_applications')->where('id', $id)->update([
            'status'     => $newStatus,
            'updated_at' => now(),
        ]);

        // Notify the user about status change
        $job = DB::table('job_listings')->where('id', $app->job_id)->first();
        $messages = [
            'shortlisted' => "Congratulations! Your application for \"{$job->title}\" has been shortlisted. Stay tuned for further updates.",
            'interview'   => "Great news! You have been selected for an interview for \"{$job->title}\". Our team will contact you with interview details shortly.",
            'selected'    => "Congratulations! You have been selected for \"{$job->title}\". Welcome aboard! Our HR team will contact you soon.",
            'rejected'    => "Thank you for applying to \"{$job->title}\". After careful review, we regret to inform you that your application was not selected this time. Keep applying!",
            'pending'     => "Your application for \"{$job->title}\" is under review.",
        ];

        \App\Models\Notification::create([
            'user_id' => $app->user_id,
            'title'   => 'Application Status Updated',
            'message' => $messages[$newStatus] ?? "Your application status has been updated to: " . ucfirst($newStatus),
            'type'    => 'job',
            'is_read' => false,
        ]);

        return back()->with('success', 'Application status updated and user notified.');
    }
}
