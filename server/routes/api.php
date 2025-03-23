<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/', fn() => 'hello');

Route::group(["prefix" => "v0.1"], function () {
    // get all users
    Route::get('/users', [UserController::class, 'all']);

    // single user
    Route::post('/users', [UserController::class, 'create']);
    Route::get('/users/{id}', [UserController::class, 'read']);
    Route::put('/users/{id}', [UserController::class, 'createOrUpdate']);
    Route::patch('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'delete']);
});
