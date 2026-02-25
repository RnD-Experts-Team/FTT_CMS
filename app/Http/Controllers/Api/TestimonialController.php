<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Http\Requests\StoreTestimonialRequest;
use App\Http\Requests\UpdateTestimonialRequest;
use App\Services\TestimonialService;
use Illuminate\Http\JsonResponse;
use Exception;

class TestimonialController extends Controller
{
    protected $testimonialService;

    public function __construct(TestimonialService $testimonialService)
    {
        $this->testimonialService = $testimonialService;
    }
       // تابع للـ Index - عرض قائمة Testimonials مع ترتيب حسب sort_order
    public function index(): JsonResponse
    {
        try {
            $testimonials = $this->testimonialService->getAll();
            return response()->json([
                'success' => true,
                'message' => 'Testimonials fetched successfully.',
                'data' => $testimonials,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch testimonials.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // تابع للـ Show - عرض Testimonial واحد بناءً على الـ ID
    public function show(int $id): JsonResponse
    {
        try {
            $testimonial = $this->testimonialService->getById($id);
            return response()->json([
                'success' => true,
                'message' => 'Testimonial fetched successfully.',
                'data' => $testimonial,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch testimonial.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(StoreTestimonialRequest $request): JsonResponse
    {
        try {
            $testimonial = $this->testimonialService->create($request->validated());
            return response()->json([
                'success' => true,
                'message' => 'Testimonial created successfully.',
                'data' => $testimonial,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create testimonial.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(int $id, UpdateTestimonialRequest $request): JsonResponse
    {
        try {
            $testimonial = $this->testimonialService->update($id, $request->validated());
            return response()->json([
                'success' => true,
                'message' => 'Testimonial updated successfully.',
                'data' => $testimonial,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update testimonial.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->testimonialService->delete($id);
            return response()->json([
                'success' => true,
                'message' => 'Testimonial deleted successfully.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete testimonial.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}