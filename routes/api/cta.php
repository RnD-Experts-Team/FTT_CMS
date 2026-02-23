<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CtaController;

Route::middleware('auth:sanctum')->prefix('ctas')->group(function () {
    Route::get('/', [CtaController::class, 'index']);
    Route::post('/', [CtaController::class, 'store']);
    Route::get('/{cta}', [CtaController::class, 'show']);
    Route::put('/{cta}', [CtaController::class, 'update']);
    Route::delete('/{cta}', [CtaController::class, 'destroy']);
});