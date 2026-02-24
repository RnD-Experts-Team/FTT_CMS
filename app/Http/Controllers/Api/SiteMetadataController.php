<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSiteMetadataRequest;
use App\Services\SiteMetadataService;
use Illuminate\Http\JsonResponse;
use Throwable;

class SiteMetadataController extends Controller
{
    private SiteMetadataService $service;

    public function __construct(SiteMetadataService $service)
    {
        $this->service = $service;
    }

    // عرض البيانات الحالية للموقع
    public function index(): JsonResponse
    {
        try {
            $data = $this->service->getSiteMetadata();
            if (!$data) {
                return response()->json([
                    'success' => false,
                    'message' => 'Site metadata not found',
                ], 404);
            }
            return response()->json([
                'success' => true,
                'message' => 'Site metadata fetched successfully',
                'data' => $data,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch site metadata',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
 

    // تحديث بيانات الموقع
    public function update(StoreSiteMetadataRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $updatedData = $this->service->update(1, $data, $request->file('logo'), $request->file('favicon'));
            return response()->json([
                'success' => true,
                'message' => 'Site metadata updated successfully',
                'data' => $updatedData,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update site metadata',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}