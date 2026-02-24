<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateGallerySectionRequest;
use App\Services\GallerySectionService;
use Illuminate\Http\JsonResponse;
use Throwable;

class GallerySectionController extends Controller
{
    private GallerySectionService $service;

    public function __construct(GallerySectionService $service)
    {
        $this->service = $service;
    }

    // عرض جميع الأقسام
    public function index(): JsonResponse
    {
        try {
            $data = $this->service->index();
            return response()->json([
                'success' => true,
                'message' => 'Gallery sections fetched successfully',
                'data' => $data,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch gallery sections',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // تحديث قسم معين
    public function update(UpdateGallerySectionRequest $request, int $id): JsonResponse
    {
        try {
            $data = $request->validated();
            $updatedData = $this->service->update($id, $data);
            return response()->json([
                'success' => true,
                'message' => 'Gallery section updated successfully',
                'data' => $updatedData,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update gallery section',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}