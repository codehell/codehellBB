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

Route::group(['middleware' => 'web', 'namespace' => 'Codehell\Codehellbb\Controllers'], function () {

    Route::get('/home', 'HomeController@index');

    Route::get('login', [
        'uses' => 'Auth\LoginController@showLoginForm',
        'as'   => 'login'
    ]);

    Route::post('login', [
        'uses' => 'Auth\LoginController@login'
    ]);

    Route::get('register', [
        'uses' => 'Auth\RegisterController@showRegistrationForm'
    ]);

    Route::post('register', [
        'uses' => 'Auth\RegisterController@register'
    ]);

    Route::post('logout', [
        'uses' => 'Auth\LoginController@logout'
    ]);

    Route::get('registration-confirm/{token}', [
        'uses'  => 'Frms\ProfilesController@getConfirmation',
        'as'    => 'confirmation'
    ]);

    Route::group(['middleware' => ['auth', 'forum'], 'namespace' => 'Frms'], function(){
      require __DIR__ . '/forums.routes.php';
    });

    Route::group(['middleware' => 'auth', 'namespace' => 'Frms', 'prefix' => 'profiles'], function () {
        require  __DIR__ . '/profiles.routes.php';
    });


    Route::group(['middleware' => 'is_admin'], function () {
        Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
    });

    Route::get('pruebas', function() {

        /** @var \App\User $user */
        $user = auth()->user();
        dd($user->unvisitedPosts()->pluck('forum_id', 'id')->has());
    });
});
