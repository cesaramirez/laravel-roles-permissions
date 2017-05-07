<?php

Route::get('/', function (\Illuminate\Http\Request $request) {
    $user = $request->user();

    if ( $user ) {
        dump($user->withdrawPermissionTo(['edit posts']));
    }
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin', function () {
    return 'admin';
})->middleware('role:admin');

Route::get('/admin/users', function () {
    return 'admin users';
})->middleware('role:admin,delete users');
