<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/',[HomeController::class,'index'])->name('home');


Route::post('/hotels-list',[HomeController::class,'hotelsList'])->name('check.availability');
Route::get('/room-details/{id}',[HomeController::class,'hotelDetailsData'])->name('see.room');

Route::post('/make-payment',[HomeController::class,'makeOrder'])->name('make.payment');


Route::get('/hotels-data',[HomeController::class,'hotelSearchData'])->name('search.data');


