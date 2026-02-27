<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NeedsItemController;

Route::middleware('auth:sanctum')
    ->prefix('needs-items')
    ->group(function () {

        Route::get('/', [NeedsItemController::class, 'index']);
        Route::get('/{needsItem}', [NeedsItemController::class, 'show']);
        Route::post('/', [NeedsItemController::class, 'store']);
        Route::put('/{needsItem}', [NeedsItemController::class, 'update']);
        Route::delete('/{needsItem}', [NeedsItemController::class, 'destroy']);

    });