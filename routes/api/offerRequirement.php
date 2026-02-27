<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OfferRequirementController;

Route::middleware('auth:sanctum')
    ->prefix('offer-requirements')
    ->group(function () {
        Route::get('/', [OfferRequirementController::class, 'index']);      
        Route::get('/{id}', [OfferRequirementController::class, 'show']);     
        Route::post('/', [OfferRequirementController::class, 'store']);     
        Route::put('/{id}', [OfferRequirementController::class, 'update']);  
        Route::delete('/{id}', [OfferRequirementController::class, 'destroy']);  
    });