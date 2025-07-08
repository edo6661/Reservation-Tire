<?php

use App\Http\Controllers\Admin\AdminReservationController;
use App\Http\Controllers\Customer\CustomerReservationController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::resource('reservations', AdminReservationController::class);
    Route::post('reservations/{id}/confirm', [AdminReservationController::class, 'confirm'])->name('reservations.confirm');
    Route::post('reservations/{id}/reject', [AdminReservationController::class, 'reject'])->name('reservations.reject');
    Route::get('availability/check', [AdminReservationController::class, 'checkAvailability'])->name('availability.check');
    Route::get('availability/slots/{date}', [AdminReservationController::class, 'getAvailableSlots'])->name('availability.slots');
});

Route::prefix('customer')->name('customer.')->middleware(['auth', 'customer'])->group(function () {
    Route::resource('reservations', CustomerReservationController::class);
    Route::post('reservations/{id}/cancel', [CustomerReservationController::class, 'cancel'])->name('reservations.cancel');
    Route::get('availability/check', [CustomerReservationController::class, 'checkAvailability'])->name('availability.check');
    Route::get('availability/slots/{date}', [CustomerReservationController::class, 'getAvailableSlots'])->name('availability.slots');
});