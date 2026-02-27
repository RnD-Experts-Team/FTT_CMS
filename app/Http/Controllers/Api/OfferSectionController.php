<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOfferSectionRequest;
use App\Services\OfferSectionService;
use Illuminate\Http\JsonResponse;
use Throwable;

class OfferSectionController extends Controller
{
    private OfferSectionService $service;

    public function __construct(OfferSectionService $service)
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
                'message' => 'Offer sections fetched successfully',
                'data' => $data,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch offer sections',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // تحديث قسم معين
    public function update(UpdateOfferSectionRequest $request, int $id): JsonResponse
    {
        try {
            $data = $request->validated();
            $updatedData = $this->service->update($id, $data, $request->file('image'));
            return response()->json([
                'success' => true,
                'message' => 'Offer section updated successfully',
                'data' => $updatedData,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update offer section',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}