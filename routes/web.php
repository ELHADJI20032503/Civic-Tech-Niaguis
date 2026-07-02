<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

// 1. Le formulaire s'affiche sur la racine OU sur /login (Évite l'erreur GET /login)
Route::match(['get', 'post'], '/', function () {
    return view('auth.login');
})->name('login');

Route::get('/login', function () {
    return redirect('/');
});

// 2. Traitement de la soumission du formulaire
Route::post('/login-action', [LoginController::class, 'login'])->name('login.post');

// 3. Tes portails de destinations officielles (Exigence F-01)
Route::get('/relais/dashboard', function () { return "Bienvenue sur le Portail Relais Terrain !"; })->name('relais.dashboard');
Route::get('/mairie/dashboard', function () { return "Bienvenue sur le Portail de Caisse de la Mairie !"; })->name('mairie.dashboard');
Route::get('/admin/dashboard', function () { return "Bienvenue sur le Panneau d'Administration Système !"; })->name('admin.dashboard');
