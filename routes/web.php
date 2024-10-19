<?php

use Illuminate\Support\Facades\Route;

Auth::routes([
    'register' => true,
    'verify' => true,
    'confirm' => false,
    'reset' => false
]);

Route::get('signature', [App\Http\Controllers\Web\OptionsController::class, 'signature'])->name('signature');

Route::middleware(['guest'])->group(function () {
    Route::namespace('App\Http\Controllers\Web')->group(function() {
        Route::apiResource('options', OptionsController::class);
    });
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::namespace('App\Http\Controllers\Core')->group(function() {
        Route::prefix('profile')->namespace('Profile')->group(function() {
            Route::apiResource('profile-company', ProfileCompanyController::class);
            Route::prefix('profile-document')->group(function() {
                Route::get('agreement', 'ProfileCompanyController@agreementLetter');
            });
        });

        Route::prefix('upload')->namespace('Upload')->group(function() {
            Route::apiResource('encrypt-books', UploadBooksController::class);

            Route::prefix('encrypt-books-excel')->group(function() {
                Route::post('upload', 'UploadBooksController@uploadExcel');
                Route::get('export-tpl', 'UploadBooksController@exportTpl');
            });

            Route::prefix('encrypt-books-submit')->group(function() {
                Route::post('submit-draft', 'UploadBooksController@submitDraft');
            });

            Route::prefix('encrypt-books-download')->group(function() {
                Route::get('download-file', 'UploadBooksController@downloadFile');
            });
        });

        Route::prefix('report')->namespace('Report')->group(function() {
            Route::apiResource('category-books', CategoryBooksController::class);
        });
    });

    Route::controller(App\Http\Controllers\HomeController::class)->group(function () {
        Route::get('/{any}', 'index')
            ->where('any', '.*')
            ->name('catch')
            ->middleware(['auth']);
    });
});
