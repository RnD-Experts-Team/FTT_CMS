<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Services\HomeDataService;
use Illuminate\Http\JsonResponse;

class HomeController extends Controller
{
    protected $homeDataService;

    public function __construct(HomeDataService $homeDataService)
    {
        $this->homeDataService = $homeDataService;
    }

    /**
     * Get home data including all sections excluding gallery_section.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $data = $this->homeDataService->getHomeData();

            return response()->json([
                'success' => true,
                'message' => 'Home data retrieved successfully',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch home data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}