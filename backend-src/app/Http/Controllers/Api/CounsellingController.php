<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CounsellingRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class CounsellingController extends Controller
{
    /**
     * POST /api/counselling  – book a session
     */
    public function book(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'counsellor_id'  => ['required', 'integer'],
            'preferred_date' => ['required', 'date', 'after_or_equal:today'],
            'time_slot'      => ['required', 'string'],
            'topic'          => ['required', 'string', 'max:255'],
            'notes'          => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Resolve counsellor name (in a full system, counsellors would be a DB table)
        $counsellorNames = [
            1 => 'Dr. Rajinder Kaur',
            2 => 'Mr. Amandeep Singh',
            3 => 'Ms. Priya Sharma',
        ];

        $counsellorName = $counsellorNames[$request->counsellor_id] ?? 'PGRKAM Counsellor';

        $session = CounsellingRequest::create([
            'user_id'        => $request->user()->id,
            'counsellor_name'=> $counsellorName,
            'preferred_date' => $request->preferred_date,
            'time_slot'      => $request->time_slot,
            'topic'          => $request->topic,
            'notes'          => $request->notes,
            'status'         => 'confirmed',
        ]);

        return response()->json([
            'message' => 'Counselling session booked successfully',
            'session' => $session,
        ], 201);
    }

    /**
     * GET /api/counselling/{id}
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $session = CounsellingRequest::where('user_id', $request->user()->id)
                    ->findOrFail($id);

        return response()->json(['session' => $session]);
    }

    /**
     * DELETE /api/counselling/{id}  – cancel a session
     */
    public function cancel(Request $request, int $id): JsonResponse
    {
        $session = CounsellingRequest::where('user_id', $request->user()->id)
                    ->findOrFail($id);

        $session->update(['status' => 'cancelled']);

        return response()->json(['message' => 'Session cancelled']);
    }
}
