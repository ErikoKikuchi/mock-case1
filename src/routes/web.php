<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductInteractionController;
use App\Http\Controllers\ProductSearchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use Illuminate\Support\Facades\Auth;

Route::get('/',[ProductSearchController::class,'show'])->name('home');

Route::middleware('guest')->group(function(){
    Route::post('/register',[ProfileController::class,'register']);
    Route::post('/login', [ProductSearchController::class, 'login']);
});

Route::middleware('auth')->group(function(){
    Route::get('/mypage',[ProductController::class,'index'])->name('mypage');
    Route::get('/profile-edit',[ProfileController::class,'edit']);
    Route::get('/sell',[ProductController::class,'create'])->name('sell');
    Route::get('/item/{item_id}',[ProductController::class,'show'])->name('item.detail');
});
