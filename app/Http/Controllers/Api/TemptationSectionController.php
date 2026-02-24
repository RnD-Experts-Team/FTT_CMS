<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TemptationSectionUpdateRequest;
use App\Models\TemptationSection;
use App\Services\TemptationSectionService;
use Illuminate\Http\JsonResponse;
use Throwable;

class TemptationSectionController extends Controller
{
    private TemptationSectionService $service;

    public function __construct(TemptationSectionService $service)
    {
        $this->service = $service;
    }
     public function index(): JsonResponse
    {
        try {
            // استدعاء الخدمة لجلب البيانات
            $data = $this->service->index();

            return response()->json([
                'success' => true,
                'message' => 'Temptation Sections fetched successfully',
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch temptation sections',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(TemptationSectionUpdateRequest $request, TemptationSection $temptationSection): JsonResponse
    {
        try {
            // الحصول على البيانات المدخلة (مثل النصوص، روابط الأزرار، إلخ)
            $data = $request->validated();

            // إذا كانت الصورة موجودة، نقوم بتخزينها وتحديث رابط الصورة
            if ($request->hasFile('image')) {
                // تخزين الصورة الجديدة
                $image = $this->service->storeImage($request->file('image'), $data['image_title'], $data['image_alt_text']);
                $data['image_media_id'] = $image->id; // ربط الصورة الجديدة
            }

            // تحديث البيانات في الجدول
            $updatedTemptationSection = $this->service->update($temptationSection, $data);

            // إرجاع الاستجابة بعد التحديث
            return response()->json([
                'success' => true,
                'message' => 'Temptation Section updated successfully',
                'data' => $updatedTemptationSection
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update temptation section',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}