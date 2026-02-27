<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NeedsSectionController;

Route::middleware('auth:sanctum')
    ->prefix('needs-sections')
    ->group(function () {

        Route::get('/', [NeedsSectionController::class, 'index']);
        Route::post('/{needsSection}', [NeedsSectionController::class, 'update']);

    });