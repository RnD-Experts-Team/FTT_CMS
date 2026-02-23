<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('api')->group(function () {

    require __DIR__ . '/api/auth.php';
    require __DIR__ . '/api/cta.php';
    require __DIR__.'/api/benefits-sections.php';
    require __DIR__.'/api/benefits-items.php';
    require __DIR__.'/api/needs-sections.php';
    require __DIR__.'/api/needs-items.php';
    require __DIR__.'/api/footer-contacts.php';
});