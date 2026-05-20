<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
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
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = $request->user();
        $user->update($validator->validated());

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
        $resume = Resume::updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

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
}
