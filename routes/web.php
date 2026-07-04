<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Relais\RelaisDashboardController;
use App\Http\Controllers\Mairie\MairieDashboardController;

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

Route::get('/mairie/dashboard', [MairieDashboardController::class, 'index'])->name('mairie.dashboard');
Route::post('/mairie/traiter/{id}', [MairieDashboardController::class, 'validerDossier'])->name('mairie.traiter');

Route::get('/admin/dashboard', function () { 
    return "Bienvenue sur le Panneau d'Administration Système !"; 
})->name('admin.dashboard');

// 4. Actions métiers du Relais Terrain (Saisie multi-actes complète)
Route::get('/relais/choisir-acte', [RelaisDashboardController::class, 'choix_acte'])->name('relais.choix_acte');

Route::get('/relais/nouvelle-demande-naissance', [RelaisDashboardController::class, 'create'])->name('relais.create');
Route::post('/relais/nouvelle-demande-naissance', [RelaisDashboardController::class, 'store'])->name('relais.store');

Route::get('/relais/nouvelle-demande-mariage', [RelaisDashboardController::class, 'create_mariage'])->name('relais.create_mariage');
Route::post('/relais/nouvelle-demande-mariage', [RelaisDashboardController::class, 'store_mariage'])->name('relais.store_mariage');

Route::get('/relais/nouvelle-demande-deces', [RelaisDashboardController::class, 'create_deces'])->name('relais.create_deces');
Route::post('/relais/nouvelle-demande-deces', [RelaisDashboardController::class, 'store_deces'])->name('relais.store_deces');


