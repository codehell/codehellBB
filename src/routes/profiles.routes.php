<?php

Route::get('/', [
    'uses' => 'ProfilesController@index',
    'as'   => 'profiles.index'
]);
Route::get('{user}/edit', [
    'uses' => 'ProfilesController@edit',
    'as'   => 'profiles.edit'
]);
Route::patch('{user}', [
    'uses' => 'ProfilesController@update',
    'as'   => 'profiles.update'
]);
Route::patch('{user}/edit-password', [
    'uses' => 'ProfilesController@updatePassword',
    'as'   => 'profiles.password'
]);

Route::patch('{user}/edit-email', [
    'uses' => 'ProfilesController@updateEmail',
    'as'   => 'profiles.email'
]);

Route::patch('{user}/edit-role', [
    'uses' => 'ProfilesController@updateRole',
    'as'   => 'profiles.roles'
]);

Route::get('{user}/send-confirmation', [
    'uses' => 'ProfilesController@askForConfirmationCode',
    'as'   => 'profiles.send_confirmation_code'
]);

Route::patch('{user}/ban', [
    'uses' => 'ProfilesController@banUser',
    'as' => 'profiles.ban_user'
]);