<?php

use Illuminate\Support\Facades\Route;
use App\WebPage\Controllers\MetaAnalyzerController;
use App\WebPage\Middlewares\WebPageRequestValidatorMiddleware;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get("/test", function () {
    return "App running...!";
});

Route::post("webpage/analyze", [MetaAnalyzerController::class, "analyzeMetaData"])
    ->middleware(WebPageRequestValidatorMiddleware::class);

Route::post("webpage/preview", [MetaAnalyzerController::class, "createPreview"])
    ->middleware(WebPageRequestValidatorMiddleware::class);
