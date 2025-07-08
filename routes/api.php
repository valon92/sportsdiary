<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NewsController; // Importojmë NewsController
use App\Http\Controllers\Api\VideoController; // Importojmë VideoController

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Këtu mund të regjistroni rrugët API për aplikacionin tuaj. Këto rrugë
| ngarkohen nga RouteServiceProvider dhe të gjitha do t'i caktohen
| grupit të middleware-it "api". Ndërtoni diçka të mrekullueshme!
|
*/

// Kjo rrugë është e Laravel-it si default, tregon përdoruesin e autentifikuar
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API Routes për News
// Route::apiResource krijon automatikisht rrugë CRUD (Create, Read, Update, Delete)
// GET    /api/news           -> NewsController@index
// POST   /api/news           -> NewsController@store
// GET    /api/news/{news}    -> NewsController@show
// PUT    /api/news/{news}    -> NewsController@update
// DELETE /api/news/{news}    -> NewsController@destroy
Route::apiResource('news', NewsController::class);

// API Routes për Videos (Spotlight/Reels)
// Këtu gjithashtu përdorim apiResource për CRUD
// GET    /api/videos           -> VideoController@index
// POST   /api/videos           -> VideoController@store
// GET    /api/videos/{video}   -> VideoController@show
// PUT    /api/videos/{video}   -> VideoController@update
// DELETE /api/videos/{video}   -> VideoController@destroy
Route::apiResource('videos', VideoController::class);

// Rrugë shtesë për funksionalitetin e pëlqimit të videove
// POST /api/videos/{video}/toggle-like
Route::post('videos/{video}/toggle-like', [VideoController::class, 'toggleLike']);