<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GalleryItemController;

 
Route::middleware('auth:sanctum')
    ->prefix('gallery-items')
    ->group(function () {
        Route::get('/', [GalleryItemController::class, 'index']);       
        Route::get('/{id}', [GalleryItemController::class, 'show']);   
        Route::post('/', [GalleryItemController::class, 'store']);     
        Route::put('/{id}', [GalleryItemController::class, 'update']);  
        Route::delete('/{id}', [GalleryItemController::class, 'destroy']);  
    });