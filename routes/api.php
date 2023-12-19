<?php

use Illuminate\Support\Facades\Artisan;
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

Route::get("/check", function () {
    return "App running...!";
});

Route::get('/clear', function () {
    $commandExecuted = [];

    Artisan::call('cache:clear');
    $commandExecuted[] = "Cache cleared!";

    Artisan::call('view:clear');
    $commandExecuted[] = "View cleared!";

    Artisan::call('config:cache');
    $commandExecuted[] = "Config cleared!";

    Artisan::call('optimize');
    $commandExecuted[] = "Optimized!";

    return $commandExecuted;
});

Route::post("webpages/analyze", [MetaAnalyzerController::class, "analyzeMetaData"])
    ->middleware(WebPageRequestValidatorMiddleware::class);

Route::post("webpages/preview", [MetaAnalyzerController::class, "createPreview"])
    ->middleware(WebPageRequestValidatorMiddleware::class);

Route::get("webpages/paginate", [MetaAnalyzerController::class, "getAllWebpages"]);
Route::get("webpages/metadata/update-all", [MetaAnalyzerController::class, "updateAllMetadata"]);
Route::get("webpages/preview/{id}", [MetaAnalyzerController::class, "getPreviewById"]);
