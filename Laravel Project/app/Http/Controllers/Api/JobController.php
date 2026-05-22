<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    /**
     * GET /api/jobs
     * Supports: ?type=government|private, ?location=, ?search=, ?page=
     */
    public function index(Request $request): JsonResponse
    {
        $query = Job::active();

        if ($request->filled('type') && in_array($request->type, ['government', 'private'])) {
            $query->where('type', $request->type);
        }

        if ($request->filled('location')) {
            $query->where('location', 'LIKE', "%{$request->location}%");
        }

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($qb) use ($q) {
                $qb->where('title', 'LIKE', "%{$q}%")
                   ->orWhere('department', 'LIKE', "%{$q}%");
            });
        }

        $jobs = $query->orderByDesc('posted_on')->get();

        return response()->json($jobs);
    }

    /**
     * GET /api/jobs/{id}
     */
    public function show(int $id): JsonResponse
    {
        $job = Job::findOrFail($id);

        return response()->json(['job' => $job]);
    }

    /**
     * POST /api/jobs  (admin)
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title'                => ['required', 'string'],
            'department'           => ['required', 'string'],
            'location'             => ['required', 'string'],
            'type'                 => ['required', 'in:government,private'],
            'salary_range'         => ['nullable', 'string'],
            'description'          => ['nullable', 'string'],
            'vacancies'            => ['nullable', 'integer', 'min:1'],
            'application_deadline' => ['required', 'date', 'after:today'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $job = Job::create([
            ...$validator->validated(),
            'created_by' => $request->user()->id,
        ]);

        return response()->json(['message' => 'Job created', 'job' => $job], 201);
    }

    /**
     * PUT /api/jobs/{id}  (admin)
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $job = Job::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title'                => ['sometimes', 'string'],
            'department'           => ['sometimes', 'string'],
            'location'             => ['sometimes', 'string'],
            'type'                 => ['sometimes', 'in:government,private'],
            'salary_range'         => ['nullable', 'string'],
            'description'          => ['nullable', 'string'],
            'vacancies'            => ['nullable', 'integer', 'min:1'],
            'application_deadline' => ['sometimes', 'date'],
            'is_active'            => ['sometimes', 'boolean'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $job->update($validator->validated());

        return response()->json(['message' => 'Job updated', 'job' => $job]);
    }

    /**
     * DELETE /api/jobs/{id}  (admin)
     */
    public function destroy(int $id): JsonResponse
    {
        Job::findOrFail($id)->delete();

        return response()->json(['message' => 'Job deleted']);
    }

    /**
     * POST /api/jobs/{id}/save  (auth)
     */
    public function saveJob(Request $request, int $id): JsonResponse
    {
        $job  = Job::findOrFail($id);
        $user = $request->user();

        if ($user->savedJobs()->where('job_id', $id)->exists()) {
            $user->savedJobs()->detach($id);
            return response()->json(['message' => 'Job removed from saved list', 'saved' => false]);
        }

        $user->savedJobs()->attach($id);

        // Notification
        \App\Models\Notification::create([
            'user_id' => $user->id,
            'title'   => 'Job Saved',
            'message' => '"' . $job->title . '" has been saved to your list. Apply before the deadline!',
            'type'    => 'job',
            'link'    => '/saved-jobs',
            'is_read' => false,
        ]);

        return response()->json(['message' => 'Job saved', 'saved' => true]);
    }

    /**
     * POST /api/jobs/{id}/apply  (auth)
     */
    public function applyJob(Request $request, int $id): JsonResponse
    {
        $job  = Job::findOrFail($id);
        $user = $request->user();

        if (DB::table('job_applications')->where('user_id', $user->id)->where('job_id', $id)->exists()) {
            return response()->json(['message' => 'Already applied to this job'], 409);
        }

        $validated = $request->validate([
            'applicant_name' => 'required|string|max:100',
            'phone'          => 'required|string|max:20',
            'experience'     => 'required|string|max:50',
            'qualification'  => 'required|string|max:100',
            'cover_letter'   => 'nullable|string|max:2000',
            'cv'             => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $cvPath = null;
        if ($request->hasFile('cv')) {
            $cvPath = $request->file('cv')->store('cvs', 'public');
        }

        // Generate unique application reference: PGRKAM-YYYY-XXXXXXXX
        $ref = 'PGRKAM-' . date('Y') . '-' . strtoupper(substr(md5(uniqid($user->id . $id, true)), 0, 8));

        DB::table('job_applications')->insert([
            'application_ref' => $ref,
            'user_id'         => $user->id,
            'job_id'          => $id,
            'applicant_name'  => $validated['applicant_name'],
            'applicant_email' => $user->email,
            'phone'           => $validated['phone'],
            'experience'      => $validated['experience'],
            'qualification'   => $validated['qualification'],
            'cover_letter'    => $validated['cover_letter'] ?? null,
            'cv_path'         => $cvPath,
            'status'          => 'pending',
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        // Create notification
        \App\Models\Notification::create([
            'user_id' => $user->id,
            'title'   => 'Application Submitted',
            'message' => 'Your application for "' . $job->title . '" has been received. Reference: ' . $ref,
            'type'    => 'job',
            'link'    => '/my-applications',
            'is_read' => false,
        ]);

        return response()->json([
            'message'         => 'Application submitted successfully!',
            'application_ref' => $ref,
        ]);
    }
}
