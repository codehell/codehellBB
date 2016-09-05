<?php

Route::get('forums', [
    'uses'  => 'ForumsController@index',
    'as'    => 'forums.index'
]);

Route::get('forums/create', [
    'uses'  => 'ForumsController@create',
    'as'    => 'forums.create'
]);

Route::post('forums', [
    'uses'  => 'ForumsController@store',
    'as'    => 'forums.store'
]);

Route::get('forums/{slug}', [
    'uses'  => 'ForumsController@show',
    'as'    => 'forums.show'
]);

Route::get('forums/{forum}/edit', [
    'uses'  => 'ForumsController@edit',
    'as'    => 'forums.edit'
]);

Route::patch('forums/{forum}', [
    'uses'  => 'ForumsController@update',
    'as'    => 'forums.update'
]);

Route::delete('forums/{forum}', [
    'uses'  => 'ForumsController@destroy',
    'as'    => 'forums.destroy'
]);

Route::get('forums/{forum}/create-post', [
    'uses'  => 'PostsController@create',
    'as'    => 'posts.create'
]);

Route::post('forums/{forum}/create-post', [
    'uses'  => 'PostsController@store',
    'as'    => 'posts.store'
]);

Route::get('forums/{slug}/{post}', [
    'uses'  => 'PostsController@show',
    'as'    => 'posts.show'
]);

Route::get('forums/{slug}/edit/{post}', [
    'uses'  => 'PostsController@edit',
    'as'    => 'posts.edit'
]);

Route::patch('update-post/{post}', [
    'uses'  => 'PostsController@update',
    'as'    => 'posts.update'
]);

Route::delete('delete-post/{post}', [
    'uses'  => 'PostsController@destroy',
    'as'    => 'posts.destroy'
]);

Route::post('add-comment/{post}/{comment?}', [
    'uses'  => 'CommentsController@store',
    'as'    => 'comments.store'
]);

Route::patch('update-comment/{comment}', [
    'uses'  => 'CommentsController@update',
    'as'    => 'comments.update'
]);

Route::delete('destroy-comment/{comment}', [
    'uses' => 'CommentsController@destroy',
    'as'   => 'comments.destroy'
]);