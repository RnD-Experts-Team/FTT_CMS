<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NeedsSection;
use App\Services\NeedsSectionService;
use App\Http\Requests\NeedsSectionIndexRequest;
use App\Http\Requests\NeedsSectionUpdateRequest;
use Illuminate\Http\JsonResponse;
use Throwable;

class NeedsSectionController extends Controller
{
    public function __construct(
        private readonly NeedsSectionService $service
    ) {}

    public function index(NeedsSectionIndexRequest $request): JsonResponse
    {
        try {
            $data = $this->service->index($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Needs sections fetched successfully',
                'data' => $data,
                'meta' => []
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch needs sections',
                'data' => [],
                'meta' => ['error' => $e->getMessage()]
            ], 500);
        }
    }

    public function update(
        NeedsSectionUpdateRequest $request,
        NeedsSection $needsSection
    ): JsonResponse {
        try {
            $updated = $this->service->update(
                $needsSection,
                $request->validated()
            );

            return response()->json([
                'success' => true,
                'message' => 'Needs section updated successfully',
                'data' => $updated,
                'meta' => []
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update needs section',
                'data' => [],
                'meta' => ['error' => $e->getMessage()]
            ], 500);
        }
    }
}