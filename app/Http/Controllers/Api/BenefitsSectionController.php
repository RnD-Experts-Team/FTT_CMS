<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BenefitsSection;
use App\Services\BenefitsSectionService;
use App\Http\Requests\BenefitsSectionIndexRequest;
use App\Http\Requests\BenefitsSectionUpdateRequest;
use Illuminate\Http\JsonResponse;
use Throwable;

class BenefitsSectionController extends Controller
{
    public function __construct(
        private readonly BenefitsSectionService $service
    ) {}

   public function index(BenefitsSectionIndexRequest $request): JsonResponse
    {
        try {
            $data = $this->service->index($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Benefits sections fetched successfully',
                'data' => $data, // مباشرة collection
                'meta' => []
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch benefits sections',
                'data' => [],
                'meta' => ['error' => $e->getMessage()]
            ], 500);
        }
    }

 

    public function update(
        BenefitsSectionUpdateRequest $request,
        BenefitsSection $benefitsSection
    ): JsonResponse {
        try {
            $updated = $this->service->update(
                $benefitsSection,
                $request->validated()
            );

            return response()->json([
                'success' => true,
                'message' => 'Benefits section updated successfully',
                'data' => $updated,
                'meta' => []
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update benefits section',
                'data' => [],
                'meta' => ['error' => $e->getMessage()]
            ], 500);
        }
    }
}