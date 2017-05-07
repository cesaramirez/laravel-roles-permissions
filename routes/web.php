<?php

Route::get('/', function (\Illuminate\Http\Request $request) {
    $user = $request->user();

    if ( $user ) {
        dump($user->withdrawPermissionTo(['edit posts']));      
    }
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
