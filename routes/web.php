<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ProfileController;

// Formulaire d'authentification principal
Route::get('/', function () { return view('auth.login'); })->name('login');
Route::post('/login-action', [LoginController::class, 'login'])->name('login.post');

// Page de sélection de profil (La maquette de Moutarou)
Route::get('/selection-profil', function () { return view('auth.profil'); })->name('profil.view');
Route::post('/selection-profil-action', [ProfileController::class, 'select'])->name('profil.select');

// Directions finales de redirection (Jalons métiers)
Route::get('/relais/dashboard', function () { return "Bienvenue sur ton espace de saisie, Relais Communautaire !"; })->name('relais.dashboard');
Route::get('/mairie/dashboard', function () { return "Bienvenue sur le portail de validation, Officier d'Etat Civil !"; })->name('mairie.dashboard');
