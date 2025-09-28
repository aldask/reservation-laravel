<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RestaurantController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/restaurants', function () {
    $restaurants = \App\Models\Restaurant::with('tables')->get();
    return view('restaurants/list', compact('restaurants'));
})->name('restaurants.list');

Route::get('/restaurants/create', function () {
    return view('restaurants/create');
})->name('restaurants.create');

Route::post('/restaurants', [RestaurantController::class, 'store'])->name('restaurants.store');

Route::get('/reserve', function () {
    $restaurants = \App\Models\Restaurant::all();
    return view('reservations/create', compact('restaurants'));
})->name('reserve');

Route::post('/reservations', [ReservationController::class, 'store'])->name('reservation.submit');

Route::get('/reservations', function () {
    $reservations = \App\Models\Reservation::with(['restaurant', 'tables', 'guests'])->get();
    return view('reservations/list', compact('reservations'));
})->name('reservations.list');