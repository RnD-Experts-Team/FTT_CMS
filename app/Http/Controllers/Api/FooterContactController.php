<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FooterContact;
use App\Services\FooterContactService;
use App\Http\Requests\FooterContactIndexRequest;
use App\Http\Requests\FooterContactUpdateRequest;
use Illuminate\Http\JsonResponse;
use Throwable;

class FooterContactController extends Controller
{
    public function __construct(
        private readonly FooterContactService $service
    ) {}

    public function index(): JsonResponse
    {
        try {
            $data = $this->service->index();

            return response()->json([
                'success' => true,
                'message' => 'Footer contacts fetched successfully',
                'data' => $data,
                'meta' => []
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch footer contacts',
                'data' => [],
                'meta' => ['error' => $e->getMessage()]
            ], 500);
        }
    }

    public function update(
        FooterContactUpdateRequest $request,
        FooterContact $footerContact
    ): JsonResponse {
        try {
            $updated = $this->service->update(
                $footerContact,
                $request->validated()
            );

            return response()->json([
                'success' => true,
                'message' => 'Footer contact updated successfully',
                'data' => $updated,
                'meta' => []
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update footer contact',
                'data' => [],
                'meta' => ['error' => $e->getMessage()]
            ], 500);
        }
    }
}