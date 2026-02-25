<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;
use App\Services\HeroSectionService;
 use App\Http\Requests\HeroSectionUpdateRequest;
use Illuminate\Http\JsonResponse;
use Throwable;

class HeroSectionController extends Controller
{
    public function __construct(
        private readonly HeroSectionService $service
    ) {}

    public function index(): JsonResponse
    {
        try {
            $data = $this->service->index();

            return response()->json([
                'success' => true,
                'message' => 'Hero sections fetched successfully',
                'data' => $data,
                'meta' => []
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch hero sections',
                'data' => [],
                'meta' => [
                    'error' => $e->getMessage()
                ]
            ], 500);
        }
    }

    public function update(HeroSectionUpdateRequest $request, HeroSection $heroSection): JsonResponse
    {
        try {
            // مهم: validated() ما بيرجع الملفات أحيانًا بشكل مضمون مع form-data
            // لذلك ندمج validated + الملفات مباشرة
            $data = $request->validated();

            if ($request->hasFile('media_files')) {
                $data['media_files'] = $request->file('media_files'); // array of UploadedFile
            }

            $updated = $this->service->update($heroSection, $data);

            return response()->json([
                'success' => true,
                'message' => 'Hero section updated successfully',
                'data' => $updated,
                'meta' => []
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update hero section',
                'data' => [],
                'meta' => [
                    'error' => $e->getMessage()
                ]
            ], 500);
        }
    }
}