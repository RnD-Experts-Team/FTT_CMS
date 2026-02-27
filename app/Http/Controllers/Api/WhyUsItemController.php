<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWhyUsItemRequest;
use App\Services\WhyUsItemService;
use Illuminate\Http\JsonResponse;
use Throwable;

class WhyUsItemController extends Controller
{
    private WhyUsItemService $service;

    public function __construct(WhyUsItemService $service)
    {
        $this->service = $service;
    }

    // عرض جميع المتطلبات
    public function index(): JsonResponse
    {
        try {
            $data = $this->service->index();
            return response()->json([
                'success' => true,
                'message' => 'Why us items fetched successfully',
                'data' => $data,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch why us items',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // عرض تفاصيل مطلب معين
    public function show(int $id): JsonResponse
    {
        try {
            $data = $this->service->show($id);
            if (!$data) {
                return response()->json([
                    'success' => false,
                    'message' => 'Why us item not found',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Why us item fetched successfully',
                'data' => $data,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch why us item',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // إنشاء مطلب جديد
    public function store(StoreWhyUsItemRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $createdData = $this->service->store($data, $request->file('icon'));
            return response()->json([
                'success' => true,
                'message' => 'Why us item created successfully',
                'data' => $createdData,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create why us item',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // تحديث مطلب معين
    public function update(StoreWhyUsItemRequest $request, int $id): JsonResponse
    {
        try {
            $data = $request->validated();
            $updatedData = $this->service->update($id, $data, $request->file('icon'));
            return response()->json([
                'success' => true,
                'message' => 'Why us item updated successfully',
                'data' => $updatedData,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update why us item',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // حذف مطلب معين
    public function destroy(int $id): JsonResponse
    {
        try {
            $deleted = $this->service->destroy($id);
            if (!$deleted) {
                return response()->json([
                    'success' => false,
                    'message' => 'Why us item not found',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Why us item deleted successfully',
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete why us item',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}