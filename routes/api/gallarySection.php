<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GallerySectionController;

Route::middleware('auth:sanctum')
    ->prefix('gallery-sections')
    ->group(function () {
        Route::get('/', [GallerySectionController::class, 'index']);     
        Route::post('/{id}', [GallerySectionController::class, 'update']);   
    });