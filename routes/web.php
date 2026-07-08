<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Relais\RelaisDashboardController;
use App\Http\Controllers\Mairie\MairieDashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;
// ==========================================
// 1. AUTHENTIFICATION & SÉLECTION DE PROFIL (NF-02)
// ==========================================
Route::match(['get', 'post'], '/', function () { return view('auth.login'); })->name('login');
Route::get('/login', function () { return redirect('/'); });
Route::post('/login-action', [LoginController::class, 'login'])->name('login.post');
Route::get('/selection-profil', function () { return view('auth.profil'); })->name('profil.view');
Route::post('/selection-profil-action', [ProfileController::class, 'select'])->name('profil.select');

// ==========================================
// 2. ESPACE RELAIS TERRAIN (SAISIE MULTI-ACTES)
// ==========================================
Route::get('/relais/dashboard', [RelaisDashboardController::class, 'index'])->name('relais.dashboard');
Route::get('/relais/choisir-acte', [RelaisDashboardController::class, 'choix_acte'])->name('relais.choix_acte');
Route::get('/relais/nouvelle-demande-naissance', [RelaisDashboardController::class, 'create'])->name('relais.create');
Route::post('/relais/nouvelle-demande-naissance', [RelaisDashboardController::class, 'store'])->name('relais.store');
Route::get('/relais/nouvelle-demande-mariage', [RelaisDashboardController::class, 'create_mariage'])->name('relais.create_mariage');
Route::post('/relais/nouvelle-demande-mariage', [RelaisDashboardController::class, 'store_mariage'])->name('relais.store_mariage');
Route::get('/relais/nouvelle-demande-deces', [RelaisDashboardController::class, 'create_deces'])->name('relais.create_deces');
Route::post('/relais/nouvelle-demande-deces', [RelaisDashboardController::class, 'store_deces'])->name('relais.store_deces');

// ==========================================
// 3. ESPACE VALIDATION MAIRIE (ROUTES STRUCTURÉES)
// ==========================================
// Les 4 pages principales connectées à ton contrôleur
Route::get('/mairie/tableau-de-bord', [MairieDashboardController::class, 'tableauDeBord'])->name('mairie.tableau_de_bord');
Route::get('/mairie/dashboard', [MairieDashboardController::class, 'index'])->name('mairie.dashboard');
Route::get('/mairie/citoyens', [MairieDashboardController::class, 'citoyens'])->name('mairie.citoyens');
Route::get('/mairie/statistiques', [MairieDashboardController::class, 'statistiques'])->name('mairie.statistiques');
Route::get('/mairie/documents-officiels', [MairieDashboardController::class, 'documents'])->name('mairie.documents');

// Les 2 pages secondaires (Rapports et Paramètres) isolées et sécurisées
// Remplace le bloc de la fonction anonyme par cette ligne propre :
Route::get('/mairie/rapports', [MairieDashboardController::class, 'tableauDeBord'])->name('mairie.rapports');


Route::get('/mairie/parametres', function () {
    $nb_en_attente = DB::table('demandes')->where('statut', 'Reçu')->count();
    return view('mairie.parametres', compact('nb_en_attente')); // Renvoie spécifiquement sur ta page de configuration
})->name('mairie.parametres');

// Traitement POST pour l'instruction et la caisse
Route::post('/mairie/traiter/{id}', [MairieDashboardController::class, 'validerDossier'])->name('mairie.traiter');

// ==========================================
// ==========================================
// 4. PORTAIL ET REQUÊTES SUPER-ADMINISTRATEUR (LOGIQUE COMPLÈTE)


Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/gestion-agents', [AdminDashboardController::class, 'agents'])->name('admin.agents');
Route::post('/admin/gestion-agents/creer', [AdminDashboardController::class, 'storeAgent'])->name('admin.agents.store');
Route::get('/admin/statistiques', [AdminDashboardController::class, 'statistiques'])->name('admin.statistiques');
Route::get('/admin/rapports-systeme', [AdminDashboardController::class, 'rapports'])->name('admin.rapports');
Route::get('/admin/configuration', [AdminDashboardController::class, 'configuration'])->name('admin.configuration');
