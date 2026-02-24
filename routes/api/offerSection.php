<?php
use App\Http\Controllers\Api\OfferSectionController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')
    ->prefix('offer-sections')
    ->group(function () {
        Route::get('/', [OfferSectionController::class, 'index']);      // عرض جميع الأقسام
        Route::post('/{id}', [OfferSectionController::class, 'update']);  // تحديث قسم معين
    });