<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::group([
    
    'prefix' => 'auth'
    
], function ($router) {
    
    Route::post('register', RegisterController::class);
    Route::post('login', [AuthController::class, 'login']);    

});

Route::group([
    
    'middleware' => 'web',
    
], function ($router) {
    Route::get('profile', ProfileController::class);
});


Auth::routes();
