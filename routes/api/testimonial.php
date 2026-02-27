<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TestimonialController;
 
Route::prefix('testimonials')->group(function () {
    Route::get('/', [TestimonialController::class, 'index']); 
    Route::get('/{id}', [TestimonialController::class, 'show']);  
    Route::post('/', [TestimonialController::class, 'store']);  
    Route::put('/{id}', [TestimonialController::class, 'update']);  
    Route::delete('/{id}', [TestimonialController::class, 'destroy']); 
});