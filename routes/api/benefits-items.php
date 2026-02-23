<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BenefitsItemController;

Route::middleware('auth:sanctum')
    ->prefix('benefits-items')
    ->group(function () {

        Route::get('/', [BenefitsItemController::class, 'index']);
        Route::get('/{benefitsItem}', [BenefitsItemController::class, 'show']);
        Route::post('/', [BenefitsItemController::class, 'store']);
        Route::put('/{benefitsItem}', [BenefitsItemController::class, 'update']);
        Route::delete('/{benefitsItem}', [BenefitsItemController::class, 'destroy']);

    });