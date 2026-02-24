<?php

use App\Http\Controllers\Api\TestimonialsSectionController;
use Illuminate\Support\Facades\Route;


Route::get('/testimonials-sections', [TestimonialsSectionController::class, 'index']);
Route::post('/testimonials-sections/{id}', [TestimonialsSectionController::class, 'update']);