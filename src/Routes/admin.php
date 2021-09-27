<?php

use Illuminate\Support\Facades\Route;
use Tir\Setting\Controllers\AdminSettingController;

// // Add web middleware for use Laravel feature
// Route::group(['middleware' => 'web'], function () {

//     //add admin prefix and middleware for admin area to user module
//     Route::group(['prefix' => 'admin', 'middleware' => 'IsAdmin'], function () {
//         // Route::resource('/setting', 'Tir\Setting\Controllers\AdminSettingController');
// //        Route::get('/setting', 'Tir\Setting\Controllers\AdminSettingController@editSetting')->name('setting.edit');
// //        Route::get('/setting', 'Tir\Setting\Controllers\AdminSettingController@editSetting')->name('setting.index');
//         Route::put('/setting', [AdminSettingControlle::class, 'saveSetting'])->name('admin.setting.update');
//     });

// });


Route::group(['middleware' => 'auth:api', 'prefix' => 'api/v1/{locale}/admin'], function () {
    Route::get('/setting/{key}',[AdminSettingController::class, 'editSetting'])->name('admin.setting.edit');
    // Route::get('/setting', 'Tir\Setting\Controllers\AdminSettingController@editSetting')->name('setting.index');
    Route::post('/setting', [AdminSettingController::class, 'saveSetting'])->name('admin.setting.update');
});