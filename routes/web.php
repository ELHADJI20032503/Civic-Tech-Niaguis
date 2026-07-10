<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Relais\RelaisDashboardController;
use App\Http\Controllers\Mairie\MairieDashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;

// ==========================================
// 1. AUTHENTIFICATION & SÉLECTION DE PROFIL 
// ==========================================
Route::get('/', function () { return view('auth.login'); })->name('login');
Route::get('/login', function () { return redirect('/'); });

Route::post('/login-action', [LoginController::class, 'login'])->name('login.post');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');



// LA ROUTE CRUCIALE DE SÉLECTION DE PROFIL
Route::get('/selection-profil', function () { return view('auth.profil'); })->name('profil.view');
Route::post('/selection-profil-action', [ProfileController::class, 'select'])->name('profil.select');

// ==========================================
// 2. ESPACE VALIDATION MAIRIE 
// ==========================================
Route::group(['prefix' => 'mairie'], function () {
    Route::get('/tableau-de-bord', [MairieDashboardController::class, 'tableauDeBord'])->name('mairie.tableau_de_bord');
    Route::get('/dashboard', [MairieDashboardController::class, 'index'])->name('mairie.dashboard');
    Route::get('/citoyens', [MairieDashboardController::class, 'citoyens'])->name('mairie.citoyens');
    Route::get('/statistiques', [MairieDashboardController::class, 'statistiques'])->name('mairie.statistiques');
    Route::get('/documents-officiels', [MairieDashboardController::class, 'documents'])->name('mairie.documents');
    Route::get('/rapports', [MairieDashboardController::class, 'tableauDeBord'])->name('mairie.rapports');
    Route::get('/parametres', function () {
        $nb_en_attente = DB::table('demandes')->where('statut', 'Reçu')->count();
        return view('mairie.parametres', compact('nb_en_attente'));
    })->name('mairie.parametres');
    Route::post('/traiter/{id}', [MairieDashboardController::class, 'validerDossier'])->name('mairie.traiter');
});

// ==========================================
// 3. ESPACE SUPER-ADMINISTRATEUR
// ==========================================
Route::group(['prefix' => 'admin'], function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/gestion-agents', [AdminDashboardController::class, 'agents'])->name('admin.agents');
    Route::post('/admin/gestion-agents/creer', [AdminDashboardController::class, 'storeAgent'])->name('admin.agents.store');
    Route::get('/statistiques', [AdminDashboardController::class, 'statistiques'])->name('admin.statistiques');
    Route::get('/rapports-systeme', [AdminDashboardController::class, 'rapports'])->name('admin.rapports');
    Route::get('/configuration', [AdminDashboardController::class, 'configuration'])->name('admin.configuration');
});

// ==========================================
// 4. ESPACE RELAIS TERRAIN
// ==========================================
Route::group(['prefix' => 'relais'], function () {
    Route::get('/dashboard', [RelaisDashboardController::class, 'index'])->name('relais.dashboard');
    Route::get('/choisir-acte', [RelaisDashboardController::class, 'choix_acte'])->name('relais.choix_acte');
    Route::get('/nouvelle-demande-naissance', [RelaisDashboardController::class, 'create'])->name('relais.create');
    Route::post('/nouvelle-demande-naissance', [RelaisDashboardController::class, 'store'])->name('relais.store');
    Route::get('/nouvelle-demande-mariage', [RelaisDashboardController::class, 'create_mariage'])->name('relais.create_mariage');
    Route::post('/nouvelle-demande-mariage', [RelaisDashboardController::class, 'store_mariage'])->name('relais.store_mariage');
    Route::get('/nouvelle-demande-deces', [RelaisDashboardController::class, 'create_deces'])->name('relais.create_deces');
    Route::post('/nouvelle-demande-deces', [RelaisDashboardController::class, 'store_deces'])->name('relais.store_deces');
});
