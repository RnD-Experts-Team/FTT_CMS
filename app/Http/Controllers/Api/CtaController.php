<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CtaIndexRequest;
use App\Http\Requests\CtaStoreRequest;
use App\Http\Requests\CtaUpdateRequest;

use App\Models\Cta;
use App\Services\CtaService;
use Illuminate\Http\JsonResponse;
use Throwable;

class CtaController extends Controller
{
    public function __construct(private readonly CtaService $service)
    {
    }

    public function index(CtaIndexRequest $request): JsonResponse
    {
        try {
            $paginated = $this->service->paginate($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'CTAs fetched successfully',
                'data'    => $paginated->items(),
                'meta'    => [
                    'pagination' => [
                        'current_page' => $paginated->currentPage(),
                        'per_page'     => $paginated->perPage(),
                        'total'        => $paginated->total(),
                        'last_page'    => $paginated->lastPage(),
                    ],
                ],
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch CTAs',
                'data'    => [],
                'meta'    => [
                    'error' => $e->getMessage(),
                ],
            ], 500);
        }
    }

    public function show(Cta $cta): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'CTA fetched successfully',
                'data'    => $cta,
                'meta'    => [],
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch CTA',
                'data'    => [],
                'meta'    => [
                    'error' => $e->getMessage(),
                ],
            ], 500);
        }
    }

    public function store(CtaStoreRequest $request): JsonResponse
    {
        try {
            $cta = $this->service->create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'CTA created successfully',
                'data'    => $cta,
                'meta'    => [],
            ], 201);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create CTA',
                'data'    => [],
                'meta'    => [
                    'error' => $e->getMessage(),
                ],
            ], 500);
        }
    }

    public function update(CtaUpdateRequest $request, Cta $cta): JsonResponse
    {
        try {
            $cta = $this->service->update($cta, $request->validated());

            return response()->json([
                'success' => true,
                'message' => 'CTA updated successfully',
                'data'    => $cta,
                'meta'    => [],
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update CTA',
                'data'    => [],
                'meta'    => [
                    'error' => $e->getMessage(),
                ],
            ], 500);
        }
    }

    public function destroy(Cta $cta): JsonResponse
    {
        try {
            $this->service->delete($cta);

            return response()->json([
                'success' => true,
                'message' => 'CTA deleted successfully',
                'data'    => [],
                'meta'    => [],
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete CTA',
                'data'    => [],
                'meta'    => [
                    'error' => $e->getMessage(),
                ],
            ], 500);
        }
    }
}