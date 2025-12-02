<?php

use App\Http\Controllers\authController;
use App\Http\Controllers\userController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/sanctum/csrf-cookie', function () {
    return response('CSRF cookie set');
});
Route::post('/login', [authController::class, 'login']);
Route::get('/check-auth', function () {
    return response()->json(['authenticated' => Auth::check()]);
});
//group middleware sanctum auth
Route::middleware('auth:sanctum')->group(function(){
    Route::post('/logOut', [authController::class, 'logOut']);
    //user
    Route::get('/user',[userController::class,'index']);
    Route::post('/user', [userController::class, 'simpanData']);
    Route::post('/user/{id}', [userController::class, 'updateData']);
    Route::delete('/user/{id}', [userController::class, 'hapusData']);
});
