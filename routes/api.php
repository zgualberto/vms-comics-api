<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth.custom'])->group(function() {
    Route::get('/authors', [App\Http\Controllers\AuthorController::class, 'index'])->name('authors.list');
    Route::get('/comics', [App\Http\Controllers\ComicController::class, 'index'])->name('comics.list');
});
