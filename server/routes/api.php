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

    // single user
    Route::post('/users', [UserController::class, 'create']);
    Route::get('/users/{id}', [UserController::class, 'read']);
    Route::put('/users/{id}', [UserController::class, 'createOrUpdate']);
    Route::patch('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'delete']);




    // Route::group(["middleware" => "auth:api"], function(){
    //     //Admin Routes
    //     Route::group(["prefix" => "admin", "middleware" => "isAdmin"], function(){
    //         Route::get('/dashboard', [DashboardController::class, "dashboard"]);
    //     });

        //User Routes
        Route::group(["prefix" => "user"], function(){
                Route::post('/add_update_question/{id?}', [UserController::class, "addOrUpdateQuestion"]);
                
                //Admin Routes (Authorization)
                Route::group(["middleware" => "manager"], function(){ //middleware needs to be defined
                    Route::post('/delete_question/{id}', [UserController::class, "deleteQuestion"]);
                });
        });

    //     //Common Routes
    //     Route::post('/edit_profile', [AuthController::class, "editProfile"]);

    // });


    // //Unauthenticated Routes
    // Route::group(["prefix" => "guest"], function () {
        Route::post('/login', [UserController::class, "login"]);
        Route::post('/logout', [UserController::class, "logout"]);
    //     Route::post('/signup', [AuthController::class, "signup"]);
    // });



    Route::middleware('auth:api')->group(function () {
        Route::get('/snippets', [SnippetController::class, 'index']);   // Get all snippets
        Route::post('/snippets', [SnippetController::class, 'store']);  // Create a new snippet
        Route::get('/snippets/{id}', [SnippetController::class, 'show']); // Get a specific snippet
        Route::put('/snippets/{id}', [SnippetController::class, 'update']); // Update a snippet
        Route::delete('/snippets/{id}', [SnippetController::class, 'destroy']); // Delete a snippet
    });
});
