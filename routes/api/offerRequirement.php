<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OfferRequirementController;

Route::middleware('auth:sanctum')
    ->prefix('offer-requirements')
    ->group(function () {
        Route::get('/', [OfferRequirementController::class, 'index']);      // عرض جميع المتطلبات
        Route::get('/{id}', [OfferRequirementController::class, 'show']);    // عرض تفاصيل مطلب معين
        Route::post('/', [OfferRequirementController::class, 'store']);     // إنشاء مطلب جديد
        Route::put('/{id}', [OfferRequirementController::class, 'update']);  // تحديث مطلب معين
        Route::delete('/{id}', [OfferRequirementController::class, 'destroy']); // حذف مطلب معين
    });