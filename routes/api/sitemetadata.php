<?php
use App\Http\Controllers\Api\SiteMetadataController;
use Illuminate\Support\Facades\Route;
Route::middleware('auth:sanctum')
    ->prefix('site_metadata')
    ->group(function () {
        Route::get('/', [SiteMetadataController::class, 'index']);      // عرض بيانات الموقع
         Route::post('/{id}', [SiteMetadataController::class, 'update']);     // تحديث بيانات الموقع
    });