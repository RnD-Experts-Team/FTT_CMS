<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GalleryItemController;

 
Route::middleware('auth:sanctum')
    ->prefix('gallery-items')
    ->group(function () {
        Route::get('/', [GalleryItemController::class, 'index']);      // عرض جميع العناصر
        Route::get('/{id}', [GalleryItemController::class, 'show']);    // عرض عنصر محدد
        Route::post('/', [GalleryItemController::class, 'store']);     // إضافة عنصر جديد
        Route::put('/{id}', [GalleryItemController::class, 'update']);  // تحديث عنصر محدد
        Route::delete('/{id}', [GalleryItemController::class, 'destroy']); // حذف عنصر
    });