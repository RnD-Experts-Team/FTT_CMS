<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FooterContactController;

Route::middleware('auth:sanctum')
    ->prefix('footer-contacts')
    ->group(function () {

        Route::get('/', [FooterContactController::class, 'index']);
        Route::post('/{footerContact}', [FooterContactController::class, 'update']);

    });