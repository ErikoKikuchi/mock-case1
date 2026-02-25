<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductInteractionController;
use App\Http\Controllers\ProductSearchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;


Route::get('/',[ProductSearchController::class,'show'])->name('home');
Route::get('/item/{item_id}',[ProductController::class,'show'])->name('item.detail');
Route::get('/purchase/success', [PurchaseController::class, 'success'])
        ->name('purchase.success');


Route::middleware('guest')->group(function(){
    Route::post('/register',[ProfileController::class,'register']);
    Route::post('/login', [ProductSearchController::class, 'login']);
});

Route::middleware('auth')->group(function(){
    Route::get('/email/verify', function () {return view('auth.verify-email');
    })->name('verification.notice');
    Route::get('/redirect', function () {return redirect()->away(config('services.mailtrap.sandbox_url'));}) ->name('verification.open');
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back();
    })->middleware('throttle:6,1')->name('verification.send');
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();return redirect()->route('profile.edit');
    })->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/mypage',[ProductController::class,'index'])->name('mypage');
    Route::get('/mypage/profile',[ProfileController::class,'edit'])->name('profile.edit');
    Route::get('/sell',[ProductController::class,'create'])->name('sell');
    Route::post('products/{product}/like', [ProductInteractionController::class, 'toggle'])->name('like.product');
    Route::get('/purchase/{item_id}',[PurchaseController::class,'show'])->name('purchase.show');
    Route::post('/comment/{item_id}',[ProductInteractionController::class,'store'])->name('comment');
    Route::get('/purchase/address/{item_id}',[PurchaseController::class,'edit'])->name('shipping.address.edit');
    Route::post('/purchase',[PurchaseController::class, 'store'])->name('purchase.store');
    Route::patch('/create/shipping-address/{item_id}',[PurchaseController::class, 'create'])->name('create.shipping-address');
    Route::patch('/update/profile',[ProfileController::class,'update'])->name('profile.update');
    Route::post('/exhibition',[ProductController::class,'store'])->name('exhibition.store');
});

