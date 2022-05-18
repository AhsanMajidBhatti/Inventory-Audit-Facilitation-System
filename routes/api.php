<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/allusers', [AuthController::class, 'alluser'])->middleware('auth:sanctum');
Route::get('/alladmins', [AuthController::class, 'alladmin'])->middleware('auth:sanctum');
Route::get('/allproductfiles', [AuthController::class, 'allproduct'])->middleware('auth:sanctum');


Route::get('/allproducts', [ProductController::class, 'allproduct'])->middleware('auth:sanctum');
Route::get('/productlist', [ProductController::class, 'index'])->middleware('auth:sanctum');
Route::get('/productview/{id}', [ProductController::class, 'view'])->middleware('auth:sanctum');
Route::get('/productsearch/{id}', [ProductController::class, 'search'])->middleware('auth:sanctum');

Route::delete('/productdel/{id}', [ProductController::class, 'delete'])->middleware('auth:sanctum');
Route::post('/create', [ProductController::class, 'create'])->middleware('auth:sanctum');
Route::post('/update/{id}', [ProductController::class, 'update'])->middleware('auth:sanctum');
Route::post('/locationupdate/{id}', [ProductController::class, 'locationupd'])->middleware('auth:sanctum');

//  Admin Users
Route::get('/userlist', [UserController::class, 'index'])->middleware('auth:sanctum');
Route::delete('/userdel/{id}', [UserController::class, 'destroy'])->middleware('auth:sanctum');
Route::get('/userview/{id}', [UserController::class, 'show'])->middleware('auth:sanctum');
Route::post('/userupdate/{id}', [UserController::class, 'update'])->middleware('auth:sanctum');
Route::post('/usercreate', [UserController::class, 'store'])->middleware('auth:sanctum');


Route::get('/allcolumn', [ProductController::class, 'getAllColumn'])->middleware('auth:sanctum');
Route::post('/excellist', [ProductController::class, 'exceldata'])->middleware('auth:sanctum');
Route::get('/exportdata', [ProductController::class, 'exportdata']);