<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class TrainingController extends Controller
{
    /**
     * GET /api/training
     */
    public function index(Request $request): JsonResponse
    {
        $query = Training::where('is_active', true);

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $query->where('title', 'LIKE', "%{$request->search}%");
        }

        return response()->json($query->orderBy('title')->get());
    }

    /**
     * GET /api/training/{id}
     */
    public function show(int $id): JsonResponse
    {
        $training = Training::findOrFail($id);

        return response()->json([
            'training'        => $training,
            'available_seats' => $training->available_seats,
            'is_full'         => $training->is_full,
        ]);
    }

    /**
     * POST /api/training/{id}/enroll  (auth)
     */
    public function enroll(Request $request, int $id): JsonResponse
    {
        $training = Training::findOrFail($id);
        $user     = $request->user();

        // Already enrolled?
        if ($user->enrolledTrainings()->where('training_id', $id)->exists()) {
            return response()->json(['message' => 'Already enrolled in this training'], 409);
        }

        if ($training->is_full) {
            return response()->json(['message' => 'No seats available'], 409);
        }

        $validated = $request->validate([
            'phone'            => 'required|string|max:20',
            'qualification'    => 'required|string|max:100',
            'notes'            => 'nullable|string|max:500',
            'preferred_timing' => 'nullable|string|max:50',
        ]);

        DB::transaction(function () use ($user, $training, $id, $validated) {
            $user->enrolledTrainings()->attach($id, [
                'status'           => 'enrolled',
                'phone'            => $validated['phone'],
                'qualification'    => $validated['qualification'],
                'notes'            => $validated['notes'] ?? null,
                'preferred_timing' => $validated['preferred_timing'] ?? null,
            ]);
            $training->increment('enrolled_count');
        });

        // Create notification
        \App\Models\Notification::create([
            'user_id' => $user->id,
            'title'   => 'Training Enrollment Confirmed',
            'message' => 'You have been successfully enrolled in "' . $training->title . '". Check My Enrollments for details.',
            'type'    => 'training',
            'link'    => '/my-enrollments',
            'is_read' => false,
        ]);

        return response()->json(['message' => 'Successfully enrolled! You will receive confirmation details shortly.']);
    }
}
