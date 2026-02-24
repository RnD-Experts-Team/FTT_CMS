<?php

use App\Http\Controllers\Api\TestimonialsSectionController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')
    ->prefix('testimonials-sections')
    ->group(function () { 

        
    Route::get('/', [TestimonialsSectionController::class, 'index']);
    Route::put('/{id}', [TestimonialsSectionController::class, 'update']);
    });
