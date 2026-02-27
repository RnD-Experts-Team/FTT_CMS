<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOfferRequirementRequest;
use App\Services\OfferRequirementService;
use Illuminate\Http\JsonResponse;
use Throwable;

class OfferRequirementController extends Controller
{
    private OfferRequirementService $service;

    public function __construct(OfferRequirementService $service)
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
                'message' => 'Offer requirements fetched successfully',
                'data' => $data,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch offer requirements',
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
                    'message' => 'Offer requirement not found',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Offer requirement fetched successfully',
                'data' => $data,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch offer requirement',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // إنشاء مطلب جديد
    public function store(StoreOfferRequirementRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $createdData = $this->service->store($data);
            return response()->json([
                'success' => true,
                'message' => 'Offer requirement created successfully',
                'data' => $createdData,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create offer requirement',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // تحديث مطلب معين
    public function update(StoreOfferRequirementRequest $request, int $id): JsonResponse
    {
        try {
            $data = $request->validated();
            $updatedData = $this->service->update($id, $data);
            return response()->json([
                'success' => true,
                'message' => 'Offer requirement updated successfully',
                'data' => $updatedData,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update offer requirement',
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
                    'message' => 'Offer requirement not found',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Offer requirement deleted successfully',
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete offer requirement',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}