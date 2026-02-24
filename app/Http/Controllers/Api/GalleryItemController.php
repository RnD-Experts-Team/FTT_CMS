<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGalleryItemRequest;
use App\Services\GalleryItemService;
use Illuminate\Http\JsonResponse;
use Throwable;

class GalleryItemController extends Controller
{
    private GalleryItemService $service;

    public function __construct(GalleryItemService $service)
    {
        $this->service = $service;
    }

    // عرض جميع العناصر
    public function index(): JsonResponse
    {
        try {
            $data = $this->service->index();
            return response()->json([
                'success' => true,
                'message' => 'Gallery items fetched successfully',
                'data' => $data,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch gallery items',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // عرض العنصر بناءً على الـ ID
    public function show(int $id): JsonResponse
    {
        try {
            $data = $this->service->show($id);
            if (!$data) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gallery item not found',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Gallery item fetched successfully',
                'data' => $data,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch gallery item',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // إضافة عنصر جديد
    public function store(StoreGalleryItemRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $createdData = $this->service->store($data, $request->file('image'));
            return response()->json([
                'success' => true,
                'message' => 'Gallery item created successfully',
                'data' => $createdData,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create gallery item',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // تحديث العنصر
    public function update(StoreGalleryItemRequest $request, int $id): JsonResponse
    {
        try {
            $data = $request->validated();
            $updatedData = $this->service->update($id, $data, $request->file('image'));
            return response()->json([
                'success' => true,
                'message' => 'Gallery item updated successfully',
                'data' => $updatedData,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update gallery item',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // حذف العنصر
    public function destroy(int $id): JsonResponse
    {
        try {
            $deleted = $this->service->destroy($id);
            if (!$deleted) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gallery item not found',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Gallery item deleted successfully',
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete gallery item',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}