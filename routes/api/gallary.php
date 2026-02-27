<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GalleryController;

Route::get('/gallery', [GalleryController::class, 'index']);