<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;

Route::get('/test-user', function () {
    $user = new User();

    $user->first_name = 'John';
    $user->last_name = 'Doe';
    $user->username = 'johndoe';
    $user->email = 'johndoe@example.com';

    $user->save();

    return $user;
});

Route::get('/', function () {
    return view('welcome');
});
