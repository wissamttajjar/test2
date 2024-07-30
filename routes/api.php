<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CarsController;
use App\Http\Controllers\api\CommentController;
use Illuminate\Support\Facades\Route;

//unauthenticated api functions

//unauthenticated user api functions
Route::post("register" , [AuthController::class , "register"]);
Route::post("login" , [AuthController::class , "login"]);
Route::get("search_Car/{brand}", [CarsController::class , "searchForCar"]);
Route::get("list_comments/{product_id}" , [CommentController::class , "list"]);

//authenticated api functions
Route::group(["middleware" => ["auth:api"]] , function (){

    //authenticated user api functions
    Route::get("show-profile" , [AuthController::class , "showProfile"]);
    Route::post("logout" , [AuthController::class , "logout"]);

    //authenticated user's cars api functions
    Route::post("add-Car" , [CarsController::class , "addCar"]);
    Route::post("update-Car/{id}" , [CarsController::class , "updateCar"]);
    Route::get("delete-Car/{id}" , [CarsController::class , "deleteCar"]);
    Route::get("list-User-Car" , [CarsController::class , "listUserCar"]);

    //authenticated user's comments api functions
    Route::post("create_comment/{product_id}" , [CommentController::class , "create"]);

});
