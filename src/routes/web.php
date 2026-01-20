<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductInteractionController;
use App\Http\Controllers\ProductSearchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use Illuminate\Support\Facades\Auth;

Route::get('/',[ProductSearchController::class,'show'])->name('home');
Route::get('/item/{item_id}',[ProductController::class,'show'])->name('item.detail');


Route::middleware('guest')->group(function(){
    Route::post('/register',[ProfileController::class,'register']);
    Route::post('/login', [ProductSearchController::class, 'login']);
});

Route::middleware('auth')->group(function(){
    Route::get('/mypage',[ProductController::class,'index'])->name('mypage');
    Route::get('/profile-edit',[ProfileController::class,'edit']);
    Route::get('/sell',[ProductController::class,'create'])->name('sell');
    Route::post('products/{product}/like', [ProductInteractionController::class, 'toggle'])->name('like.product');
    Route::get('/purchase/{item_id}',[PurchaseController::class,'show'])->name('purchase.show');
    Route::post('/comment/{item_id}',[ProductInteractionController::class,'store'])->name('comment');
    Route::get('/purchase/address/{item_id}',[ProfileController::class,'edit'])->name('profile.edit');
});
//明日用のメモ
ルーティングが違うので送付先情報とプロフィールは別テーブルで考えたほうが良い。ルーティングコントローラーテーブル回りを再度考える
