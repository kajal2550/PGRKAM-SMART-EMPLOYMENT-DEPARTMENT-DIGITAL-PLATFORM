<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    /**
     * GET /api/services  – public
     */
    public function index(): JsonResponse
    {
        $services = Service::active()->get();

        return response()->json(['services' => $services]);
    }

    /**
     * GET /api/services/{id}  – public
     */
    public function show(int $id): JsonResponse
    {
        $service = Service::findOrFail($id);

        return response()->json(['service' => $service]);
    }

    /**
     * POST /api/admin/services  – admin only
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'icon'        => ['nullable', 'string'],
            'color'       => ['nullable', 'string'],
            'path'        => ['nullable', 'string'],
            'sort_order'  => ['nullable', 'integer'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $service = Service::create($validator->validated());

        return response()->json(['message' => 'Service created', 'service' => $service], 201);
    }

    /**
     * PUT /api/admin/services/{id}  – admin only
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $service = Service::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title'       => ['sometimes', 'string'],
            'description' => ['nullable', 'string'],
            'icon'        => ['nullable', 'string'],
            'color'       => ['nullable', 'string'],
            'is_active'   => ['sometimes', 'boolean'],
            'sort_order'  => ['nullable', 'integer'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $service->update($validator->validated());

        return response()->json(['message' => 'Service updated', 'service' => $service]);
    }

    /**
     * DELETE /api/admin/services/{id}  – admin only
     */
    public function destroy(int $id): JsonResponse
    {
        Service::findOrFail($id)->delete();

        return response()->json(['message' => 'Service deleted']);
    }
}
