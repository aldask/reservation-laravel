<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RestaurantController;

Route::post('/restaurants', [RestaurantController::class, 'store']);
Route::get('restaurants', [RestaurantController::class, 'index']);
Route::get('restaurants/{restaurant}', [RestaurantController::class, 'show']);
Route::get('reservations', [ReservationController::class, 'index']);
Route::post('reservations', [ReservationController::class, 'store']);