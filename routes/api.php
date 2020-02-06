<?php

Route::group([
    'prefix' => 'auth',
], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');

    Route::group([
        'middleware' => 'auth.api',
    ], function () {
        Route::post('logout', 'Auth\LoginController@logout');
        Route::get('user', 'AuthController@user');
    });
});
