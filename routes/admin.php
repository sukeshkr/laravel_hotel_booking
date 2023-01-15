<?php

use App\Http\Controllers\admin\LoginController;
use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\BookingController;
use App\Http\Controllers\admin\DashBoardController;
use App\Http\Controllers\admin\HotelBookingController;
use App\Http\Controllers\admin\RoomBookingController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class,'index'])->name('login');
Route::post('/', [LoginController::class,'postLogin'])->name('post.login');

Route::get('register', [AuthController::class,'register'])->name('register');
Route::post('/register', [AuthController::class,'postRegister'])->name('post.register');
//email verification
Route::get('/email/verify', function () {
    return view('admin.auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('admin/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');
//email verify end

//forgot password
Route::get('/forgot-password',function() {
    return view('admin.auth.forgot-password');
})->name('password.request');

Route::post('forgot',[AuthController::class,'postForgot'])->name('password.email');

Route::get('/reset-password/{token}',function($token){
    return view('admin.auth.reset-password',['token'=>$token]);
})->name('password.reset');

Route::post('password-update',[AuthController::class,'passwordUpdate'])->name('password.update');
//forgot password end

Route::group(['middleware'=>['auth','verified']],function(){

    Route::get('/dashboard',[DashBoardController::class,'index'])->name('dashboard');

    Route::get('/booking',[BookingController::class,'index'])->name('booking.list');

    Route::get('/create-hotel',[HotelBookingController::class,'getHotel'])->name('hotel');
    Route::post('/create-hotel',[HotelBookingController::class,'posteHotel'])->name('hotel.post');
    Route::get('/hotels',[HotelBookingController::class,'index'])->name('hotel.list');
    Route::get('/hotel-list',[HotelBookingController::class,'hotelFetch'])->name('hotel.fetch');
    Route::get('/hotel-edit/{id}',[HotelBookingController::class,'hotelEdit'])->name('hotel.edit');
    Route::post('/hotel-update',[HotelBookingController::class,'hotelUpdate'])->name('hotel.update');
    Route::get('/hotel-delete',[HotelBookingController::class,'hotelDestroy'])->name('hotel.delete');

    Route::get('/create-room',[RoomBookingController::class,'getRoom'])->name('room');
    Route::post('/create-room',[RoomBookingController::class,'postRoom'])->name('room.post');
    Route::get('/rooms',[RoomBookingController::class,'index'])->name('room.list');
    Route::get('/room-list',[RoomBookingController::class,'roomFetch'])->name('room.fetch');
    Route::get('/room-edit/{id}',[RoomBookingController::class,'roomEdit'])->name('room.edit');
    Route::post('/room-update',[RoomBookingController::class,'roomUpdate'])->name('room.update');
    Route::get('/room-delete',[RoomBookingController::class,'roomDestroy'])->name('room.delete');

    Route::get('logout', [AuthController::class,'logout'])->name('user.logout');

});
