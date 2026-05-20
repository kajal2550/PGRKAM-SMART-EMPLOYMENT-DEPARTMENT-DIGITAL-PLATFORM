<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Job;
use App\Models\Training;
use App\Models\CounsellingRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * GET /api/admin/dashboard
     */
    public function dashboard(): JsonResponse
    {
        return response()->json([
            'stats' => [
                'total_users'        => User::count(),
                'active_jobs'        => Job::where('is_active', true)->count(),
                'training_programs'  => Training::where('is_active', true)->count(),
                'counselling_reqs'   => CounsellingRequest::count(),
                'government_jobs'    => Job::where('type', 'government')->count(),
                'private_jobs'       => Job::where('type', 'private')->count(),
                'pending_counselling'=> CounsellingRequest::where('status', 'pending')->count(),
            ],
        ]);
    }

    /**
     * GET /api/admin/users
     */
    public function users(Request $request): JsonResponse
    {
        $query = User::query();

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($qb) use ($q) {
                $qb->where('name', 'LIKE', "%{$q}%")
                   ->orWhere('email', 'LIKE', "%{$q}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        return response()->json($query->orderByDesc('created_at')->paginate(20));
    }

    /**
     * DELETE /api/admin/users/{id}
     */
    public function deleteUser(Request $request, int $id): JsonResponse
    {
        // Prevent deleting own account
        if ($request->user()->id === $id) {
            return response()->json(['message' => 'Cannot delete your own account'], 403);
        }

        User::findOrFail($id)->delete();

        return response()->json(['message' => 'User deleted']);
    }

    /**
     * GET /api/admin/reports
     */
    public function reports(): JsonResponse
    {
        return response()->json([
            'registrations_by_month' => User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')
                ->orderBy('month')
                ->get(),

            'jobs_by_type' => Job::selectRaw('type, COUNT(*) as count')
                ->groupBy('type')
                ->get(),

            'training_enrollments' => Training::withCount('enrolledUsers')
                ->orderByDesc('enrolled_users_count')
                ->limit(5)
                ->get(),

            'counselling_by_status' => CounsellingRequest::selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->get(),
        ]);
    }

    /**
     * GET /api/admin/schemes  – placeholder for employment schemes management
     */
    public function schemes(): JsonResponse
    {
        // In production, this would query a schemes table
        return response()->json([
            'schemes' => [
                ['id' => 1, 'title' => 'Ghar Ghar Rozgar',     'type' => 'State',   'beneficiaries' => 12500],
                ['id' => 2, 'title' => 'PM Kaushal Vikas',      'type' => 'Central', 'beneficiaries' => 8400],
                ['id' => 3, 'title' => 'Startup Punjab',        'type' => 'State',   'beneficiaries' => 3200],
                ['id' => 4, 'title' => 'Apprenticeship Scheme', 'type' => 'Central', 'beneficiaries' => 5600],
            ],
        ]);
    }

    /**
     * POST /api/admin/schemes
     */
    public function addScheme(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title'   => ['required', 'string'],
            'type'    => ['required', 'in:State,Central'],
            'details' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Would persist to DB in production
        return response()->json(['message' => 'Scheme added successfully'], 201);
    }
}
