<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Services\GalleryService;
use Illuminate\Http\JsonResponse;

class GalleryController extends Controller
{
    protected $galleryService;

    public function __construct(GalleryService $galleryService)
    {
        $this->galleryService = $galleryService;
    }

    /**
      *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
             $gallerySections = $this->galleryService->getGallerySections();

            return response()->json([
                'success' => true,
                'message' => 'Gallery section retrieved successfully',
                'data' => [
                    'gallery_section' => $gallerySections
                ],
                'meta' => []
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch gallery sections',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}