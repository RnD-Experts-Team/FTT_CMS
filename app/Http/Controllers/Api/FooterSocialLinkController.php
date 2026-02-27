<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FooterSocialLink;
use App\Services\FooterSocialLinkService;
use App\Http\Requests\FooterSocialLinkIndexRequest;
use App\Http\Requests\FooterSocialLinkUpdateRequest;
use Illuminate\Http\JsonResponse;
use Throwable;

class FooterSocialLinkController extends Controller
{
    public function __construct(
        private readonly FooterSocialLinkService $service
    ) {}

    public function index(FooterSocialLinkIndexRequest $request): JsonResponse
    {
        try {
            $data = $this->service->index($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Footer social links fetched successfully',
                'data' => $data,
                'meta' => []
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch footer social links',
                'data' => [],
                'meta' => ['error' => $e->getMessage()]
            ], 500);
        }
    }

    public function update(
        FooterSocialLinkUpdateRequest $request,
        FooterSocialLink $footerSocialLink
    ): JsonResponse {
        try {
            $updated = $this->service->update(
                $footerSocialLink,
                $request->validated()
            );

            return response()->json([
                'success' => true,
                'message' => 'Footer social link updated successfully',
                'data' => $updated,
                'meta' => []
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update footer social link',
                'data' => [],
                'meta' => ['error' => $e->getMessage()]
            ], 500);
        }
    }
}