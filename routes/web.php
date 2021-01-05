<?php

use Illuminate\Http\Request;

Route::redirect('/', '/admin/login');

Route::group([
  'prefix' => 'admin',
], function () {
    Auth::routes();
    Route::view('crosslogin', 'admin.login');
    Route::post('crosslogin', 'Auth\CrossLoginController@login');
});

Route::view('crear-tienda', 'auth.register')->middleware('admin.guest');
Route::view('registro/bluecaribu', 'auth.register_bluecaribu')->middleware('admin.guest');
Route::view('registro/loreal', 'auth.register_loreal')->middleware('admin.guest');
Route::view('registro/wompi', 'auth.register_wompi')->middleware('admin.guest');
