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

        return response()->json($query->orderBy('title')->paginate(15));
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

        DB::transaction(function () use ($user, $training, $id) {
            $user->enrolledTrainings()->attach($id, ['status' => 'enrolled']);
            $training->increment('enrolled_count');
        });

        return response()->json(['message' => 'Successfully enrolled in training']);
    }
}
