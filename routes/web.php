<?php

use Illuminate\Support\Facades\Route;

Auth::routes([
    'register' => false,
    'verify' => true,
    'confirm' => false,
    'reset' => false
]);

Route::get('pendaftaran-supplier', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('pendaftaran-supplier', [App\Http\Controllers\Auth\RegisterController::class, 'register']);
Route::get('pendaftaran-client', [App\Http\Controllers\Auth\RegisterClientController::class, 'showRegistrationForm'])->name('register-client');
Route::post('pendaftaran-client', [App\Http\Controllers\Auth\RegisterClientController::class, 'register']);
Route::get('pendaftaran-distributor', [App\Http\Controllers\Auth\RegisterDistributorController::class, 'showRegistrationForm'])->name('register-distributor');
Route::post('pendaftaran-distributor', [App\Http\Controllers\Auth\RegisterDistributorController::class, 'register']);

Route::get('signature', [App\Http\Controllers\Web\OptionsController::class, 'signature'])->name('signature');
Route::get('download-file', [App\Http\Controllers\Web\OptionsController::class, 'downloadFile'])->name('downloadFile');

Route::middleware(['guest'])->group(function () {
    Route::namespace('App\Http\Controllers\Web')->group(function() {
        Route::apiResource('options', OptionsController::class);
    });
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::middleware('activated.user')->group(function() {
        Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::get('/userinfo', [App\Http\Controllers\HomeController::class, 'userinfo'])->name('userinfo');
        Route::get('/my-web-menu', [App\Http\Controllers\HomeController::class, 'webMenuAcl'])->name('web_menu_acl');

        Route::namespace('App\Http\Controllers\Web')->group(function() {
            Route::apiResource('web-access-log', WebAccessLogController::class);
        });

        Route::namespace('App\Http\Controllers\Core')->group(function() {
            Route::prefix('profile')->namespace('Profile')->group(function() {
                Route::apiResource('profile-company', ProfileCompanyController::class);
                Route::prefix('profile-document')->group(function() {
                    Route::get('download-file', 'ProfileCompanyController@downloadFile');
                    Route::get('agreement', 'ProfileCompanyController@agreementLetter');
                });
            });

            Route::prefix('upload')->namespace('Upload')->group(function() {
                Route::apiResource('encrypt-books', UploadBooksController::class);

                Route::prefix('encrypt-books-excel')->group(function() {
                    Route::post('upload', 'UploadBooksController@uploadExcel');
                    Route::post('export-tpl', 'UploadBooksController@exportTpl');
                    Route::post('export-data', 'UploadBooksController@exportData');
                });

                Route::prefix('encrypt-books-submit')->group(function() {
                    Route::post('submit-draft', 'UploadBooksController@submitDraft');
                    Route::post('submit-review', 'UploadBooksController@submitReview');
                });

                Route::prefix('encrypt-books-download')->group(function() {
                    Route::get('download-file', 'UploadBooksController@downloadFile');
                });

                Route::apiResource('encrypt-files', EncryptFileController::class);
                Route::prefix('encrypt-files-download')->group(function() {
                    Route::get('download-file', 'EncryptFileController@downloadFile');
                    Route::post('export-tpl', 'EncryptFileController@exportTpl');
                });

                Route::apiResource('data-books', UploadBooksController::class);
            });

            Route::prefix('report')->namespace('Report')->group(function() {
                Route::apiResource('category-books', CategoryBooksController::class);

                Route::apiResource('supplier-report', ReportSupplierController::class);
                Route::prefix('supplier-report-excel')->group(function() {
                    Route::get('export-tpl', 'ReportSupplierController@exportTpl');
                });

                Route::apiResource('distributor-report', ReportDistributorController::class);
                Route::prefix('distributor-report-excel')->group(function() {
                    Route::get('export-tpl', 'ReportDistributorController@exportTpl');
                });

                Route::apiResource('po-report', ReportPOController::class);
                Route::prefix('po-report-excel')->group(function() {
                    Route::post('export-tpl', 'ReportPOController@exportTpl');
                    Route::post('export-dtl-tpl', 'ReportPOController@exportTplDetail');
                });
            });

            Route::prefix('transactions')->namespace('Transactions')->group(function() {
                Route::apiResource('approval-books', ApprovalBooksController::class);
                Route::prefix('approval-books')->group(function() {
                    Route::post('reject', 'ApprovalBooksController@reject');
                });
                Route::prefix('approval-books-download')->group(function() {
                    Route::get('download-file', 'ApprovalBooksController@downloadFile');
                    Route::get('view-file', 'ApprovalBooksController@viewFile');
                });

                Route::apiResource('approval-client', ApprovalClientController::class);
                Route::prefix('approval-client')->group(function() {
                    Route::post('reject', 'ApprovalClientController@reject');
                });

                Route::apiResource('approval-supplier', ApprovalSupplierController::class);
                Route::prefix('approval-supplier')->group(function() {
                    Route::post('reject', 'ApprovalSupplierController@reject');
                });

                Route::apiResource('approval-distributor', ApprovalDistirbutorController::class);
                Route::prefix('approval-distributor')->group(function() {
                    Route::post('reject', 'ApprovalDistirbutorController@reject');
                });

                Route::apiResource('po-upload', UploadPurchaseOrderController::class);
                Route::prefix('po-upload-excel')->group(function() {
                    Route::post('upload', 'UploadPurchaseOrderController@uploadExcel');
                    Route::post('export-tpl', 'UploadPurchaseOrderController@exportTpl');
                });

                Route::apiResource('po-paid', UploadPaidOffController::class);

                Route::apiResource('approval-edit-client', ApprovalEditClientController::class);
                Route::prefix('approval-edit-client')->group(function() {
                    Route::post('reject', 'ApprovalEditClientController@reject');
                });
            });
        });
    });

    Route::controller(App\Http\Controllers\HomeController::class)->group(function () {
        Route::get('/{any}', 'index')
            ->where('any', '.*')
            ->name('catch')
            ->middleware(['auth']);
    });
});
