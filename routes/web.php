<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InventoryController;

Route::get('/', [DashboardController::class, 'index']);
Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout']);

//  profile
Route::get('/user', function(){
    return redirect('/user/profile');
});
Route::get('/user/profile', [UserController::class, 'profile']);


// inventory
Route::get('/inventory', [InventoryController::class, 'index']);
Route::post('/inventory/add', [InventoryController::class, 'add']);