<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function () {
    return "Connexion validee par les routes !";
})->name('login.post');

