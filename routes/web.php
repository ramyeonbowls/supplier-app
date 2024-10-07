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

    Route::namespace('App\Http\Controllers\Core')->group(function() {
        Route::prefix('upload')->namespace('Upload')->group(function() {
            Route::apiResource('encrypt-books', UploadBooksController::class);
            Route::prefix('encrypt-books-excel')->group(function() {
                Route::post('upload', 'UploadBooksController@uploadExcel');
                Route::get('export-tpl', 'UploadBooksController@exportTpl');
            });
        });
    });
});
