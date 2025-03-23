<?php

use App\Http\Controllers\SnippetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/', fn() => 'hello');


// version v0.1
Route::group(["prefix" => "v0.1"], function () {
    // get all users
    Route::get('/users', [UserController::class, 'all']);

    // // single user
    // Route::post('/users', [UserController::class, 'create']);
    // Route::get('/users/{id}', [UserController::class, 'read']);
    // Route::put('/users/{id}', [UserController::class, 'createOrUpdate']);
    // Route::patch('/users/{id}', [UserController::class, 'update']);
    // Route::delete('/users/{id}', [UserController::class, 'delete']);


    Route::post('/login', [UserController::class, "login"]);
    Route::post('/signup', [UserController::class, "create"]);


    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', [UserController::class, "logout"]);

        // snippet controllers
        Route::group(["prefix" => "/snippets"], function () {
            Route::get('', [SnippetController::class, 'index']);   // Get all snippets
            Route::post('', [SnippetController::class, 'store']);  // Create a new snippet
            Route::get('/{id}', [SnippetController::class, 'show']); // Get a specific snippet
            Route::put('/{id}', [SnippetController::class, 'update']); // Update a snippet
            Route::delete('/{id}', [SnippetController::class, 'destroy']); // Delete a snippet
        });
    });
});
