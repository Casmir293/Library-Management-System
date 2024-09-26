<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\BookController;
use App\Http\Controllers\api\v1\AuthorController;
use App\Http\Controllers\api\v1\RecordController;
use App\Http\Controllers\api\v1\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'v1', 'middleware' => 'auth:sanctum'], function () {

    // Books Resource
    Route::get('books', [BookController::class, 'index']);
    Route::post('books', [BookController::class, 'store'])->middleware('staff');
    Route::post('books/{id}/borrow', [BookController::class, 'borrowBook'])->middleware('member');
    Route::post('books/{id}/return', [BookController::class, 'returnBook'])->middleware('member');
    Route::get('books/{id}', [BookController::class, 'show']);
    Route::put('books/{id}', [BookController::class, 'update'])->middleware('staff');
    Route::delete('books/{id}', [BookController::class, 'destroy'])->middleware('admin');

    // Authors Resource
    Route::get('authors', [AuthorController::class, 'index']);
    Route::post('authors', [AuthorController::class, 'store'])->middleware('staff');
    Route::get('authors/{id}', [AuthorController::class, 'show']);
    Route::put('authors/{id}', [AuthorController::class, 'update'])->middleware('staff');
    Route::delete('authors/{id}', [AuthorController::class, 'destroy'])->middleware('admin');

    // Records Resource
    Route::get('borrow-records', [RecordController::class, 'index'])->middleware('staff');
    Route::get('borrow-records/{id}', [RecordController::class, 'show'])->middleware('staff');

    // Users Resource
    Route::get('users', [UserController::class, 'index'])->middleware('staff');
    // Route::post('users', [UserController::class, 'store']);
    Route::get('users/{id}', [UserController::class, 'show'])->middleware('admin');
    Route::put('users/{id}', [UserController::class, 'update']);
    Route::delete('users/{id}', [UserController::class, 'destroy'])->middleware('admin');
    Route::post('logout', [UserController::class, 'logout']);
});

Route::post('v1/users', [UserController::class, 'store']);
Route::post('v1/login', [UserController::class, 'login']);
