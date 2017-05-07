<?php

Route::get('/', function (\Illuminate\Http\Request $request) {
    $user = $request->user();

    dump($user->hasRole('admin'));
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
