<?php

Route::get('/', function (\Illuminate\Http\Request $request) {
    $user = $request->user();

    dump($user->can('edit posts'));
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
