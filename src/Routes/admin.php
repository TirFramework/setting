<?php

use Illuminate\Support\Facades\Route;
use Tir\Setting\Controllers\AdminSettingController;


Route::group(['middleware' => 'auth:api', 'prefix' => 'api/v1/admin'], function () {
    Route::get('/setting/{id}/edit',[AdminSettingController::class, 'editSetting'])->name('admin.setting.edit');
    Route::put('/setting/{id}', [AdminSettingController::class, 'saveSetting'])->name('admin.setting.update');
});