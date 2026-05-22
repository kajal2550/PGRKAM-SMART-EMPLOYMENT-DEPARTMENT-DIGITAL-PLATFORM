<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Resume;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * GET /api/user/profile
     */
    public function profile(Request $request): JsonResponse
    {
        $user = $request->user()->load(['resume', 'counsellingRequests', 'enrolledTrainings']);

        return response()->json([
            'user'              => $user,
            'saved_jobs_count'  => $user->savedJobs()->count(),
            'notifications_count' => $user->notifications()->unread()->count(),
        ]);
    }

    /**
     * PUT /api/user/profile
     */
    public function updateProfile(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name'          => ['sometimes', 'string', 'max:255'],
            'phone'         => ['sometimes', 'nullable', 'string', 'max:15'],
            'district'      => ['sometimes', 'nullable', 'string'],
            'qualification' => ['sometimes', 'nullable', 'string'],
            'skills'        => ['sometimes', 'nullable', 'string'],
            'dob'           => ['sometimes', 'nullable', 'string'],
            'gender'        => ['sometimes', 'nullable', 'string'],
            'address'       => ['sometimes', 'nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = $request->user();
        $user->update($validator->validated());

        // Notification
        Notification::create([
            'user_id' => $user->id,
            'title'   => 'Profile Updated',
            'message' => 'Your profile has been updated successfully. Keep your information up-to-date for better job matches.',
            'type'    => 'info',
            'link'    => '/profile',
            'is_read' => false,
        ]);

        return response()->json(['message' => 'Profile updated', 'user' => $user]);
    }

    /**
     * GET /api/user/notifications
     */
    public function notifications(Request $request): JsonResponse
    {
        $notifications = $request->user()
            ->notifications()
            ->orderByDesc('created_at')
            ->paginate(20);

        return response()->json($notifications);
    }

    /**
     * PUT /api/user/notifications/{id}/read
     */
    public function markNotificationRead(Request $request, int $id): JsonResponse
    {
        $notification = $request->user()->notifications()->findOrFail($id);
        $notification->update(['is_read' => true]);

        return response()->json(['message' => 'Notification marked as read']);
    }

    /**
     * GET /api/user/saved-jobs
     */
    public function savedJobs(Request $request): JsonResponse
    {
        $jobs = $request->user()->savedJobs()->paginate(15);

        return response()->json($jobs);
    }

    /**
     * GET /api/user/resume
     */
    public function getResume(Request $request): JsonResponse
    {
        $resume = $request->user()->resume;

        if (! $resume) {
            return response()->json(['resume' => null]);
        }

        return response()->json(['resume' => $resume]);
    }

    /**
     * POST /api/user/resume  – create or update
     */
    public function saveResume(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'personal'   => ['nullable', 'array'],
            'education'  => ['nullable', 'array'],
            'experience' => ['nullable', 'array'],
            'skills'     => ['nullable', 'string'],
            'languages'  => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data   = $validator->validated();
        $user   = $request->user();
        $isNew  = ! Resume::where('user_id', $user->id)->exists();
        $resume = Resume::updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

        // Notification
        Notification::create([
            'user_id' => $user->id,
            'title'   => $isNew ? 'Resume Created!' : 'Resume Updated',
            'message' => $isNew
                ? 'Your resume has been created successfully. A complete resume improves your shortlisting chances.'
                : 'Your resume has been updated. Recruiters will see your latest information.',
            'type'    => 'info',
            'link'    => '/resume',
            'is_read' => false,
        ]);

        return response()->json(['message' => 'Resume saved', 'resume' => $resume]);
    }

    /**
     * GET /api/user/counselling
     */
    public function counsellingSessions(Request $request): JsonResponse
    {
        $sessions = $request->user()
            ->counsellingRequests()
            ->orderByDesc('created_at')
            ->get();

        return response()->json(['sessions' => $sessions]);
    }

    /**
     * PUT /api/user/password
     */
    public function changePassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'string'],
            'new_password'     => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = $request->user();

        if (! Hash::check($request->current_password, $user->password)) {
            return response()->json(['errors' => ['current_password' => ['Current password is incorrect']]], 422);
        }

        $user->update(['password' => Hash::make($request->new_password)]);

        // Notification
        Notification::create([
            'user_id' => $user->id,
            'title'   => 'Password Changed',
            'message' => 'Your account password was changed successfully. If this wasn\'t you, contact support immediately.',
            'type'    => 'alert',
            'link'    => '/profile',
            'is_read' => false,
        ]);

        return response()->json(['message' => 'Password changed successfully']);
    }

    /**
     * DELETE /api/user/saved-jobs/{id}
     */
    public function unsaveJob(Request $request, int $id): JsonResponse
    {
        $request->user()->savedJobs()->detach($id);
        return response()->json(['message' => 'Job removed from saved list']);
    }

    /**
     * GET /api/user/enrollments
     */
    public function myEnrollments(Request $request): JsonResponse
    {
        $enrollments = $request->user()
            ->enrolledTrainings()
            ->withPivot('status', 'enrolled_at', 'phone', 'qualification', 'preferred_timing', 'notes')
            ->orderByPivot('enrolled_at', 'desc')
            ->get()
            ->map(function ($t) {
                return [
                    'id'               => $t->id,
                    'title'            => $t->title,
                    'provider'         => $t->provider,
                    'category'         => $t->category,
                    'duration'         => $t->duration,
                    'fee'              => $t->fee,
                    'description'      => $t->description,
                    'status'           => $t->pivot->status ?? 'enrolled',
                    'enrolled_at'      => $t->pivot->enrolled_at,
                    'preferred_timing' => $t->pivot->preferred_timing,
                    'qualification'    => $t->pivot->qualification,
                    'phone'            => $t->pivot->phone,
                    'notes'            => $t->pivot->notes,
                ];
            });

        return response()->json(['enrollments' => $enrollments]);
    }

    /**
     * GET /api/user/applications
     */
    public function myApplications(Request $request): JsonResponse
    {
        $applications = DB::table('job_applications')
            ->join('job_listings', 'job_applications.job_id', '=', 'job_listings.id')
            ->where('job_applications.user_id', $request->user()->id)
            ->select(
                'job_applications.id',
                'job_applications.application_ref',
                'job_applications.status',
                'job_applications.experience',
                'job_applications.qualification',
                'job_applications.created_at as applied_at',
                'job_listings.title as job_title',
                'job_listings.department',
                'job_listings.location',
                'job_listings.type',
                'job_listings.salary_range',
                'job_listings.application_deadline'
            )
            ->orderByDesc('job_applications.created_at')
            ->get();

        return response()->json(['applications' => $applications]);
    }
}
