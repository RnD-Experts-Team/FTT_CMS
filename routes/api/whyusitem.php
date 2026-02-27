<?php 
use App\Http\Controllers\Api\WhyUsItemController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')
    ->prefix('why-us-items')
    ->group(function () {
        Route::get('/', [WhyUsItemController::class, 'index']);
        Route::get('/{id}', [WhyUsItemController::class, 'show']);
        Route::post('/', [WhyUsItemController::class, 'store']);
        Route::put('/{id}', [WhyUsItemController::class, 'update']);
        Route::delete('/{id}', [WhyUsItemController::class, 'destroy']);
    });