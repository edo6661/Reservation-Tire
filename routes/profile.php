<?php

use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Customer\CustomerProfileController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/profile', [AdminProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [AdminProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('customer')->name('customer.')->middleware(['auth', 'customer'])->group(function () {
    Route::get('/profile', [CustomerProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [CustomerProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [CustomerProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [CustomerProfileController::class, 'destroy'])->name('profile.destroy');
});