<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\AuthorController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'v1'], function () {
    Route::get('authors', [AuthorController::class, 'index']);
    Route::post('authors', [AuthorController::class, 'store']);
    Route::get('authors/{id}', [AuthorController::class, 'show']);
    Route::put('authors/{id}', [AuthorController::class, 'update']);
    Route::delete('authors/{id}', [AuthorController::class, 'destroy']);
});
