<?php

use Illuminate\Support\Facades\Route;

Auth::routes([
    'register' => true,
    'verify' => true,
    'confirm' => false,
    'reset' => false
]);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});
