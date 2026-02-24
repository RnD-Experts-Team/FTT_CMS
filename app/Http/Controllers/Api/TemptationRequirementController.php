<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TemptationRequirementRequest;
use App\Services\TemptationRequirementService;
use Illuminate\Http\JsonResponse;
use Throwable;

class TemptationRequirementController extends Controller
{
    private TemptationRequirementService $service;

    public function __construct(TemptationRequirementService $service)
    {
        $this->service = $service;
    }

    // دالة لعرض جميع المتطلبات
    public function index(): JsonResponse
    {
        try {
            $data = $this->service->index();
            return response()->json([
                'success' => true,
                'message' => 'Temptation requirements fetched successfully',
                'data' => $data,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch temptation requirements',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // دالة لإظهار تفاصيل مطلب معين
    public function show(int $id): JsonResponse
    {
        try {
            $data = $this->service->show($id);
            if (!$data) {
                return response()->json([
                    'success' => false,
                    'message' => 'Temptation requirement not found',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Temptation requirement fetched successfully',
                'data' => $data,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch temptation requirement',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // دالة لإنشاء مطلب جديد
    public function store(TemptationRequirementRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $createdData = $this->service->store($data);
            return response()->json([
                'success' => true,
                'message' => 'Temptation requirement created successfully',
                'data' => $createdData,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create temptation requirement',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // دالة لتحديث مطلب معين
    public function update(TemptationRequirementRequest $request, int $id): JsonResponse
    {
        try {
            $data = $request->validated();
            $updatedData = $this->service->update($id, $data);
            return response()->json([
                'success' => true,
                'message' => 'Temptation requirement updated successfully',
                'data' => $updatedData,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update temptation requirement',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // دالة لحذف مطلب معين
    public function destroy(int $id): JsonResponse
    {
        try {
            $deleted = $this->service->destroy($id);
            if (!$deleted) {
                return response()->json([
                    'success' => false,
                    'message' => 'Temptation requirement not found',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Temptation requirement deleted successfully',
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete temptation requirement',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}