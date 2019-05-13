<?php

Auth::routes(['verify' => true]);

Route::get('/', 'PagesController@root')->name('root')->middleware('verified');

// auth 中间件代表需要登录，verified中间件代表需要经过邮箱验证
Route::group(['middleware' => ['auth', 'verified']], function () {

    Route::resource('user_addresses','UserAddressesController');

});