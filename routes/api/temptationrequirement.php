<?php
use App\Http\Controllers\Api\TemptationRequirementController;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')
    ->prefix('temptation-requirements')
    ->group(function () {
        Route::get('/', [TemptationRequirementController::class, 'index']);
        Route::get('/{id}', [TemptationRequirementController::class, 'show']);
        Route::post('/', [TemptationRequirementController::class, 'store']);
        Route::put('/{id}', [TemptationRequirementController::class, 'update']);
        Route::delete('/{id}', [TemptationRequirementController::class, 'destroy']);


    });
    