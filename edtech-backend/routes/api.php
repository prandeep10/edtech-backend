<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

use App\Http\Controllers\CourseController;

Route::prefix('courses')->group(function () {
    Route::get('/', [CourseController::class, 'index']);
    Route::post('/', [CourseController::class, 'store']);
    Route::get('/{id}', [CourseController::class, 'show']);
    Route::put('/{id}', [CourseController::class, 'update']);
    Route::delete('/{id}', [CourseController::class, 'destroy']);
});



use App\Http\Controllers\VideoController;
Route::prefix('videos')->group(function () {
    Route::get('/', [VideoController::class, 'index']);
    Route::post('/', [VideoController::class, 'store']);
    Route::get('/{id}', [VideoController::class, 'show']);
    Route::put('/{id}', [VideoController::class, 'update']);
    Route::delete('/{id}', [VideoController::class, 'destroy']);
});
