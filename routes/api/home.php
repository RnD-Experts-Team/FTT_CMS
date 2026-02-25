<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HomeController;

// Home Routes
Route::get('/home', [HomeController::class, 'index']);