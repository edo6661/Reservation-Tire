<?php

use App\Http\Controllers\Admin\AdminContactController;
use App\Http\Controllers\Customer\CustomerContactController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::resource('contacts', AdminContactController::class);
    Route::post('contacts/{id}/answer', [AdminContactController::class, 'answer'])->name('contacts.answer');
});

Route::prefix('customer')->name('customer.')->middleware(['auth', 'customer'])->group(function () {
    Route::resource('contacts', CustomerContactController::class)->only(['index', 'create', 'store', 'show']);
});

// buat yang ga login ya bang
Route::get('/contact', [CustomerContactController::class, 'create'])->name('contact.create');
Route::post('/contact', [CustomerContactController::class, 'store'])->name('contact.store');