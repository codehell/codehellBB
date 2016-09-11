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

use Codehell\Codehellbb\Entities\Post;

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

    Route::get('pruebas', function() {

        $post = Post::find(21);
        $comments = $post->postComments()->with('children')->get();
        function art ($comments) {
            foreach($comments as $comment) {
                echo "$comment->comment <hr>";
                if (! $comment->children->isEmpty()) {
                    $comments = $comment->children;
                    art($comments);
                }
            }
        };
        art($comments);
    });
});
