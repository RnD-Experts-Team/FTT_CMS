<?php
use App\Http\Controllers\Api\SiteMetadataController;
use Illuminate\Support\Facades\Route;
Route::middleware('auth:sanctum')
    ->prefix('site_metadata')
    ->group(function () {
        Route::get('/', [SiteMetadataController::class, 'index']);     
         Route::post('/{id}', [SiteMetadataController::class, 'update']);      
    });