<?php


// Add web middleware for use Laravel feature
Route::group(['middleware' => 'web'], function () {

    //add admin prefix and middleware for admin area to user module
    Route::group(['prefix' => 'admin', 'middleware' => 'IsAdmin'], function () {
        // Route::resource('/setting', 'Tir\Setting\Controllers\AdminSettingController');
        Route::get('/setting', 'Tir\Setting\Controllers\AdminSettingController@editSetting')->name('setting.edit');
        Route::get('/setting', 'Tir\Setting\Controllers\AdminSettingController@editSetting')->name('setting.index');
        Route::put('/setting', 'Tir\Setting\Controllers\AdminSettingController@updateSetting')->name('setting.update');
    });

});