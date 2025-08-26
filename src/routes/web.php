<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\AuthController;

Route::get('/',[ItemController::class,'index']);


Route::middleware(['auth','verified'])->group(function(){
    Route::get('/mypage',[AuthController::class,'index'])->name('mypage');
});

Route::get('/email/verify', function () {
    return view('auth.verify-email'); // Bladeを後で作成
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill(); // ユーザーを「認証済み」にする
    return redirect('/mypage/prufile'); // 認証後に遷移する場所
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');