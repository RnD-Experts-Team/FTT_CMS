<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FounderSection;
use App\Services\FounderSectionService;
 use App\Http\Requests\FounderSectionUpdateRequest;
use Illuminate\Http\JsonResponse;
use Throwable;

class FounderSectionController extends Controller
{
    public function __construct(
        private readonly FounderSectionService $service
    ) {}

    public function index(): JsonResponse
    {
        try {
            $data = $this->service->index();

            return response()->json([
                'success' => true,
                'message' => 'Founder section fetched successfully',
                'data' => $data,
                'meta' => []
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch founder section',
                'data' => [],
                'meta' => ['error' => $e->getMessage()]
            ], 500);
        }
    }

    public function update(
        FounderSectionUpdateRequest $request,
        FounderSection $founderSection
    ): JsonResponse {
        try {
            $updated = $this->service->update(
                $founderSection,
                $request->validated()
            );

            return response()->json([
                'success' => true,
                'message' => 'Founder section updated successfully',
                'data' => $updated,
                'meta' => []
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update founder section',
                'data' => [],
                'meta' => ['error' => $e->getMessage()]
            ], 500);
        }
    }
}