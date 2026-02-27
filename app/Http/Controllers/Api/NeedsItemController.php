<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NeedsItem;
use App\Services\NeedsItemService;
use App\Http\Requests\NeedsItemIndexRequest;
use App\Http\Requests\NeedsItemStoreRequest;
use App\Http\Requests\NeedsItemUpdateRequest;
use Illuminate\Http\JsonResponse;
use Throwable;

class NeedsItemController extends Controller
{
    public function __construct(
        private readonly NeedsItemService $service
    ) {}

    public function index(NeedsItemIndexRequest $request): JsonResponse
    {
        try {
            $data = $this->service->index($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Needs items fetched successfully',
                'data' => $data,
                'meta' => []
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch needs items',
                'data' => [],
                'meta' => ['error' => $e->getMessage()]
            ], 500);
        }
    }

    public function show(NeedsItem $needsItem): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'Needs item fetched successfully',
                'data' => $this->service->show($needsItem),
                'meta' => []
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch needs item',
                'data' => [],
                'meta' => ['error' => $e->getMessage()]
            ], 500);
        }
    }

    public function store(NeedsItemStoreRequest $request): JsonResponse
    {
        try {
            $item = $this->service->create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Needs item created successfully',
                'data' => $item,
                'meta' => []
            ], 201);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create needs item',
                'data' => [],
                'meta' => ['error' => $e->getMessage()]
            ], 500);
        }
    }

    public function update(
        NeedsItemUpdateRequest $request,
        NeedsItem $needsItem
    ): JsonResponse {
        try {
            $updated = $this->service->update(
                $needsItem,
                $request->validated()
            );

            return response()->json([
                'success' => true,
                'message' => 'Needs item updated successfully',
                'data' => $updated,
                'meta' => []
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update needs item',
                'data' => [],
                'meta' => ['error' => $e->getMessage()]
            ], 500);
        }
    }

    public function destroy(NeedsItem $needsItem): JsonResponse
    {
        try {
            $this->service->delete($needsItem);

            return response()->json([
                'success' => true,
                'message' => 'Needs item deleted successfully',
                'data' => [],
                'meta' => []
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete needs item',
                'data' => [],
                'meta' => ['error' => $e->getMessage()]
            ], 500);
        }
    }
}