<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ReportController;

Route::get('/', [DashboardController::class, 'index']);
Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout']);

//  user
Route::get('/user', function(){
    return redirect('/user/profile');
});
Route::get('/user/profile', [UserController::class, 'profile']);
Route::get('/user/list', [UserController::class, 'list'])->middleware(isAdmin::class);  //  admin only
Route::post('/user/find', [UserController::class, 'find'])->middleware(isAdmin::class);  //  admin only
Route::post('/user/save', [UserController::class, 'save']);
Route::post('/user/delete', [UserController::class, 'delete'])->middleware(isAdmin::class);  //  admin only


// inventory
Route::get('/inventory', [InventoryController::class, 'index'])->middleware(isAdmin::class);  //  admin only;
Route::post('/inventory/save', [InventoryController::class, 'save'])->middleware(isAdmin::class);  //  admin only;
Route::post('/inventory/find', [InventoryController::class, 'find'])->middleware(isAdmin::class);  //  admin only;
Route::post('/inventory/delete', [InventoryController::class, 'delete'])->middleware(isAdmin::class);  //  admin only;
Route::post('/inventory/find-from-code', [InventoryController::class, 'findFromCode']);


//  Unit
Route::get('/unit', [UnitController::class, 'index']);
Route::post('/unit/save', [UnitController::class, 'save']);
Route::post('/unit/delete', [UnitController::class, 'delete']);


// Category
Route::get('/category', [CategoryController::class, 'index']);
Route::post('/category/save', [CategoryController::class, 'save']);
Route::post('/category/delete', [CategoryController::class, 'delete']);

// Transaction
Route::get('/transaction', [TransactionController::class, 'index']);
Route::post('/transaction/proccess', [TransactionController::class, 'proccess']);
Route::get('/transaction/print/{id}', [TransactionController::class, 'print']);


// Members
Route::get('/member', [MemberController::class, 'index']);
Route::post('/member/save', [MemberController::class ,'save']);
Route::post('/member/delete', [MemberController::class, 'delete']);
Route::post('/member/find', [MemberController::class, 'find']);
Route::get('/member/topup', [MemberController::class, 'index']);
Route::post('/member/topup/save', [MemberController::class, 'topup']);


// Supplier
Route::get('/supplier', [SupplierController::class, 'index'])->middleware(isAdmin::class);
Route::post('/supplier/save', [SupplierController::class, 'save'])->middleware(isAdmin::class);
Route::post('/supplier/delete', [SupplierController::class, 'delete'])->middleware(isAdmin::class);

Route::get('/stock', [StockController::class, 'index'])->middleware(isWarehouse::class);
Route::post('/stock/save', [StockController::class, 'save'])->middleware(isWarehouse::class);
Route::post('/stock/delete', [StockController::class, 'delete'])->middleware(isWarehouse::class);


// Reports
Route::get('/report/purchase', [ReportController::class, 'purchase'])->middleware(isAdmin::class);
Route::get('/report/sales', [ReportController::class, 'sales'])->middleware(isAdmin::class);