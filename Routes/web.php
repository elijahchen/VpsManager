<?php

use Illuminate\Support\Facades\Route;
use Modules\VpsManager\Http\Controllers\VpsManagerController;

Route::group(['middleware' => 'auth', 'prefix' => 'vps-manager'], function() {
    Route::get('/', [VpsManagerController::class, 'index'])->name('vpsmanager.index');
    Route::post('/update', [VpsManagerController::class, 'updateInstances'])->name('vpsmanager.update');
    Route::post('/restart/{id}', [VpsManagerController::class, 'restart'])->name('vpsmanager.restart');
    Route::post('/terminate/{id}', [VpsManagerController::class, 'terminate'])->name('vpsmanager.terminate');
    Route::post('/report-issue/{id}', [VpsManagerController::class, 'reportIssue'])->name('vpsmanager.report-issue');
    Route::post('/send-notice/{id}', [VpsManagerController::class, 'sendNotice'])->name('vpsmanager.send-notice');
    Route::post('/extend-expiration/{id}', [VpsManagerController::class, 'extendExpiration'])->name('vpsmanager.extend-expiration');
});