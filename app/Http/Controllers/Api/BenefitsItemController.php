<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BenefitsItem;
use App\Services\BenefitsItemService;
use App\Http\Requests\BenefitsItemStoreRequest;
use App\Http\Requests\BenefitsItemUpdateRequest;
use App\Http\Requests\BenefitsItemIndexRequest;
use Illuminate\Http\JsonResponse;
use Throwable;

class BenefitsItemController extends Controller
{
    public function __construct(
        private readonly BenefitsItemService $service
    ) {}

    public function index(BenefitsItemIndexRequest $request): JsonResponse
    {
        try {
            $data = $this->service->index($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Benefits items fetched successfully',
                'data' => $data,
                'meta' => []
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch benefits items',
                'data' => [],
                'meta' => ['error' => $e->getMessage()]
            ], 500);
        }
    }

    public function show(BenefitsItem $benefitsItem): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'Benefits item fetched successfully',
                'data' => $this->service->show($benefitsItem),
                'meta' => []
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch benefits item',
                'data' => [],
                'meta' => ['error' => $e->getMessage()]
            ], 500);
        }
    }

    public function store(BenefitsItemStoreRequest $request): JsonResponse
    {
        try {
            $item = $this->service->create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Benefits item created successfully',
                'data' => $item,
                'meta' => []
            ], 201);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create benefits item',
                'data' => [],
                'meta' => ['error' => $e->getMessage()]
            ], 500);
        }
    }

    public function update(
        BenefitsItemUpdateRequest $request,
        BenefitsItem $benefitsItem
    ): JsonResponse {
        try {
            $updated = $this->service->update(
                $benefitsItem,
                $request->validated()
            );

            return response()->json([
                'success' => true,
                'message' => 'Benefits item updated successfully',
                'data' => $updated,
                'meta' => []
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update benefits item',
                'data' => [],
                'meta' => ['error' => $e->getMessage()]
            ], 500);
        }
    }

    public function destroy(BenefitsItem $benefitsItem): JsonResponse
    {
        try {
            $this->service->delete($benefitsItem);

            return response()->json([
                'success' => true,
                'message' => 'Benefits item deleted successfully',
                'data' => [],
                'meta' => []
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete benefits item',
                'data' => [],
                'meta' => ['error' => $e->getMessage()]
            ], 500);
        }
    }
}