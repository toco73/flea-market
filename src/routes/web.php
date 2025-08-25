<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\AuthController;

Route::get('/',[ItemController::class,'index']);


Route::middleware(['auth','verified'])->group(function(){
    Route::get('/mypage',[AuthController::class,'index'])->name('mypage');
});