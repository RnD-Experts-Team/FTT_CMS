<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateTestimonialsSectionRequest;
use App\Services\TestimonialsSectionService;
use Illuminate\Http\JsonResponse;
use Exception;
use Throwable;

class TestimonialsSectionController extends Controller
{
    private readonly TestimonialsSectionService $testimonialsSectionService;

    public function __construct(TestimonialsSectionService $testimonialsSectionService)
    {
        $this->testimonialsSectionService = $testimonialsSectionService;
    }

    /**
     * Display a listing of the testimonials sections.
     */
    public function index(): JsonResponse
    {
        try {
            $data = $this->testimonialsSectionService->getAllTestimonialsSections();

            return response()->json([
                'success' => true,
                'message' => 'Testimonials sections fetched successfully',
                'data' => $data,
                'meta' => []
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch testimonials sections',
                'data' => [],
                'meta' => ['error' => $e->getMessage()]
            ], 500);
        }
    }

    /**
     * Update the specified testimonials section.
     */
    public function update($id, StoreUpdateTestimonialsSectionRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $updatedSection = $this->testimonialsSectionService->updateTestimonialsSection($id, $data);

            return response()->json([
                'success' => true,
                'message' => 'Testimonials section updated successfully',
                'data' => $updatedSection,
                'meta' => []
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update testimonials section',
                'data' => [],
                'meta' => ['error' => $e->getMessage()]
            ], 500);
        }
    }
}