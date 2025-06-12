<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\HabitacionController;

Route::get('/', function () {
    return '¡Bienvenido a la API de Hoteles!';
});

Route::controller(HotelController::class)->prefix('hoteles')->group(function () {
    Route::get('/', 'index')->name('hoteles.index');
    Route::get('/{id}/edit', 'edit')->name('hoteles.edit');
    Route::post('/', 'store')->name('hoteles.store');
    Route::put('/{id}', 'update')->name('hoteles.update');
    Route::delete('/{id}', 'delete')->name('hoteles.delete');
});

Route::controller(HabitacionController::class)->prefix('habitaciones')->group(function () {
    Route::get('/', 'index')->name('habitaciones.index');
    Route::get('/{id}', 'show')->name('habitaciones.show');
    Route::post('/', 'store')->name('habitaciones.store');
    Route::put('/{id}', 'update')->name('habitaciones.update');
    Route::delete('/{id}', 'destroy')->name('habitaciones.destroy');
});
Route::get('/acomodaciones',[HabitacionController::class, 'getAcomodaciones'])->name('habitaciones.acomodaciones');
Route::get('/tipoHabitaciones', [HabitacionController::class, 'getTipoHabitaciones'])->name('habitaciones.tipoHabitaciones');

