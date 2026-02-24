<?php 
use App\Http\Controllers\Api\TemptationSectionController;
use Illuminate\Support\Facades\Route;
Route::middleware('auth:sanctum')
    ->prefix('temptation-sections')
    ->group(function () {
    Route::get('/', [TemptationSectionController::class, 'index']);
    Route::post('/{temptationSection}', [TemptationSectionController::class, 'update']);


 });