<?php

use App\Http\Controllers\Api\TestimonialsSectionController;
use Illuminate\Support\Facades\Route;


Route::get('/testimonials-sections', [TestimonialsSectionController::class, 'index']);
Route::put('/testimonials-sections/{id}', [TestimonialsSectionController::class, 'update']);