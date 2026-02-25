<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TestimonialController;
 
Route::prefix('testimonials')->group(function () {
    Route::get('/', [TestimonialController::class, 'index']); // عرض جميع Testimonials
    Route::get('/{id}', [TestimonialController::class, 'show']); // عرض Testimonial واحد
    Route::post('/', [TestimonialController::class, 'store']); // إنشاء Testimonial
    Route::put('/{id}', [TestimonialController::class, 'update']); // تعديل Testimonial
    Route::delete('/{id}', [TestimonialController::class, 'destroy']); // حذف Testimonial
});