<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;
use App\Services\HeroSectionService;
use App\Http\Requests\HeroSectionIndexRequest;
use App\Http\Requests\HeroSectionUpdateRequest;
use Illuminate\Http\JsonResponse;
use Throwable;

class HeroSectionController extends Controller
{
    public function __construct(
        private readonly HeroSectionService $service
    ) {}

    public function index(HeroSectionIndexRequest $request): JsonResponse
    {
        try {
            $data = $this->service->index();

            return response()->json([
                'success' => true,
                'message' => 'Hero sections fetched successfully',
                'data' => $data,
                'meta' => []
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch hero sections',
                'data' => [],
                'meta' => ['error' => $e->getMessage()]
            ], 500);
        }
    }

    public function update(
        HeroSectionUpdateRequest $request,
        HeroSection $heroSection
    ): JsonResponse {
        try {
            $updated = $this->service->update(
                $heroSection,
                $request->validated()
            );

            return response()->json([
                'success' => true,
                'message' => 'Hero section updated successfully',
                'data' => $updated,
                'meta' => []
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update hero section',
                'data' => [],
                'meta' => ['error' => $e->getMessage()]
            ], 500);
        }
    }
}