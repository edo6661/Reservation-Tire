<?php

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Customer\CustomerDashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('users', AdminUserController::class);
});

Route::prefix('customer')->name('customer.')->middleware(['auth', 'customer'])->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
});