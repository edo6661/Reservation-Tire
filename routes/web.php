<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

require __DIR__.'/auth.php';
require __DIR__.'/contact.php';
require __DIR__.'/profile.php';
require __DIR__.'/reservation.php';
require __DIR__.'/user.php';