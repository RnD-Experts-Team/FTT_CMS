<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FounderSectionController;

Route::middleware('auth:sanctum')
    ->prefix('founder-sections')
    ->group(function () {

        Route::get('/', [FounderSectionController::class, 'index']);
        Route::post('/{founderSection}', [FounderSectionController::class, 'update']);

    });