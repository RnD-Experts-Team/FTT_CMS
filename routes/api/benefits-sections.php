<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BenefitsSectionController;

Route::middleware('auth:sanctum')
    ->prefix('benefits-sections')
    ->group(function () {

        Route::get('/', [BenefitsSectionController::class, 'index']);
        Route::post('/{benefitsSection}', [BenefitsSectionController::class, 'update']);

    });