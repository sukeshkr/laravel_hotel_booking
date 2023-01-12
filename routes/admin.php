<?php

use App\Http\Controllers\admin\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/',[LoginController::class,'index'])->name('login');
