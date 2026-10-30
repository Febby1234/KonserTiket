<?php

use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::post('/bookings', [BookingController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('bookings.store');
