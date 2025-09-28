<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\AuthController;

//商品一覧画面
Route::get('/',[ItemController::class,'index']);

//商品詳細画面
Route::get('/item/{item_id}',[ItemController::class,'show'])->name('item');
Route::post('/comments',[ItemController::class,'comment'])->middleware('auth')->name('comment');

//いいね機能
Route::post('/items/{item}/like',[ItemController::class,'like'])->name('items.like');
Route::delete('/items/{item}/unlike',[ItemController::class,'unlike'])->name('items.unlike');

//商品購入画面
Route::middleware('auth')->group(function(){
    Route::get('/purchase/{item_id}',[ItemController::class,'purchaseShow'])->name('purchase.show');
    Route::post('/purchase/{item_id}',[ItemController::class,'purchaseStore'])->name('purchase.store');
    //送付先住所変更画面
    Route::get('/purchase/address/{item_id}',[ItemController::class,'address'])->name('purchase.address');
    Route::patch('/purchase/address/{item_id}',[ItemController::class,'updateAddress'])->name('purchase.address.update');
});
//Stripe用
Route::get('/stripe/checkout/{item_id}',[ItemController::class,'checkout'])->name('stripe.checkout');
Route::post('/stripe/checkout/{item_id}',[ItemController::class,'checkout'])->name('checkout');
Route::get('/stripe/success',[ItemController::class,'success'])->name('stripe.success');
Route::get('/stripe/cancel',[ItemController::class,'cancel'])->name('stripe.cancel');

//ログイン画面
Route::get('/login',[AuthController::class,'showLoginForm'])->name('login');
Route::post('/login',[AuthController::class,'login']);

//プロフィール画面
Route::get('/mypage',[ItemController::class,'mypage'])->middleware(['auth','verified'])->name('mypage');

//プロフィール編集画面
Route::get('/mypage/profile',function(){
    return view('profile');
})->middleware(['auth','verified'])->name('mypage.profile');
Route::get('/maypage/profile',[ItemController::class,'edit'])->name('profile.edit');
Route::patch('/maypage/profile',[ItemController::class,'update'])->middleware(['auth','verified'])->name('profile.update');

//メール認証機能
Route::get('/email/verify', function () {
    return view('auth.verify-email'); 
})->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill(); // ユーザーを「認証済み」にする
    return redirect()->route('mypage.profile'); // 認証後に遷移する場所
    return redirect()->route('mypage');
})->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

//認証メール再送機能
Route::post('/email/verification-notification', function (Request $request) {
    if ($request->user()->hasVerifiedEmail()) {
        return redirect()->intended(RouteServiceProvider::HOME);
    }
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');

//商品出品画面
Route::get('/sell',[ItemController::class,'create'])->middleware('auth')->name('items.create');
Route::post('/sell',[ItemController::class,'store'])->middleware('auth')->name('items.store');