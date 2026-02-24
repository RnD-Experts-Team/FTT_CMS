<?php 
use App\Http\Controllers\Api\TemptationSectionController;
use Illuminate\Support\Facades\Route;
Route::get('/temptation-sections', [TemptationSectionController::class, 'index']);
Route::post('/temptation-sections/{temptationSection}', [TemptationSectionController::class, 'update']);