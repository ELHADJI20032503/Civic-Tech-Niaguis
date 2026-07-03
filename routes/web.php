<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Relais\RelaisDashboardController;

// 1. Authentification globale (NF-02)
Route::match(['get', 'post'], '/', function () {
    return view('auth.login');
})->name('login');

Route::get('/login', function () {
    return redirect('/');
});

Route::post('/login-action', [LoginController::class, 'login'])->name('login.post');

// 2. Sélection du profil utilisateur (Maquette Moutarou)
Route::get('/selection-profil', function () { return view('auth.profil'); })->name('profil.view');
Route::post('/selection-profil-action', [ProfileController::class, 'select'])->name('profil.select');

// 3. Portails de destinations officielles (Exigence F-01 / Maquette Penda)
// BRANCHEMENT LOGIQUE SUR TON NOUVEAU CONTROLEUR BACKEND DYNAMIQUE
Route::get('/relais/dashboard', [RelaisDashboardController::class, 'index'])->name('relais.dashboard');

Route::get('/mairie/dashboard', function () { 
    return "Bienvenue sur le Portail de Caisse de la Mairie !"; 
})->name('mairie.dashboard');

Route::get('/admin/dashboard', function () { 
    return "Bienvenue sur le Panneau d'Administration Système !"; 
})->name('admin.dashboard');

// 4. Actions métiers du Relais Terrain (Jalon 3 - Saisie multi-actes)
Route::get('/relais/nouvelle-demande', function () {
    return "Interface de saisie multi-actes (Naissance, Mariage, Décès) en cours de préparation backend.";
})->name('relais.create');
