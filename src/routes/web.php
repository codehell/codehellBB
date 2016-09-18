<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => 'web', 'namespace' => 'App\Http\Controllers'], function () {

    // Authentication Routes...
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout');

    // Password Reset Routes...
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
});

Route::group(['middleware' => 'web', 'namespace' => 'Codehell\Codehellbb\Controllers'], function () {

    Route::get('register', [
        'uses' => 'Auth\RegisterController@showRegistrationForm'
    ]);

    Route::post('register', [
        'uses' => 'Auth\RegisterController@register'
    ]);

    Route::get('registration-confirm/{token}', [
        'uses'  => 'Frms\ProfilesController@getConfirmation',
        'as'    => 'confirmation'
    ]);

    Route::group(['middleware' => ['auth', 'forum', 'is_banned'], 'namespace' => 'Frms'], function(){
      require __DIR__ . '/forums.routes.php';
    });

    Route::group(['middleware' => ['auth', 'is_banned'], 'namespace' => 'Frms', 'prefix' => 'profiles'], function () {
        require  __DIR__ . '/profiles.routes.php';
    });


    Route::group(['middleware' => 'is_admin'], function () {
        Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
    });

    Route::get('{user}/banned-message', function () {
        return view('codehellbb::profiles.banned');
    })->name('profiles.ban_message');

});
