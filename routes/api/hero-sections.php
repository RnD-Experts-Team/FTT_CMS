<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HeroSectionController;

Route::middleware('auth:sanctum')
    ->prefix('hero-sections')
    ->group(function () {

        Route::get('/', [HeroSectionController::class, 'index']);
        Route::post('/{heroSection}', [HeroSectionController::class, 'update']);

    });