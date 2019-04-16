<?php

Auth::routes(['verify' => true]);

Route::get('/','PagesController@root')->name('root')->middleware('verified');

