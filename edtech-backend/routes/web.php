<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('thumbnails/{filename}', function ($filename) {
    $path = storage_path('app/thumbnails/' . $filename);

    if (!file_exists($path)) {
        abort(404);
    }

    $file = file_get_contents($path);

    return response($file, 200)->header('Content-Type', 'image/png'); // Adjust the Content-Type based on your image type
})->name('thumbnails');
