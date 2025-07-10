<?php

use Illuminate\Support\Facades\Route;
use App\Enums\ServiceType;

Route::get('/', function () {
    return view('home', ['services' => ServiceType::cases()]);
})->name('home');

require __DIR__.'/auth.php';
require __DIR__.'/contact.php';
require __DIR__.'/profile.php';
require __DIR__.'/reservation.php';
require __DIR__.'/user.php';