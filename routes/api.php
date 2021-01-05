<?php

use App\Models\Customer\Option;

Route::group([
    'prefix' => 'v1',
], function () {
    Route::post('register', 'API\Auth\RegisterController@register')->name('register');
});
