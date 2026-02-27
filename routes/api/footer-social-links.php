<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FooterSocialLinkController;

Route::middleware('auth:sanctum')
    ->prefix('footer-social-links')
    ->group(function () {

        Route::get('/', [FooterSocialLinkController::class, 'index']);
        Route::post('/{footerSocialLink}', [FooterSocialLinkController::class, 'update']);

    });