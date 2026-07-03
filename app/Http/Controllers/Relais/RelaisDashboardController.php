<?php

namespace App\Http\Controllers\Relais;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RelaisDashboardController extends Controller
{
    public function index()
    {
        // On récupère l'identifiant du relais connecté en session
        $id_relais = Auth::id() ?? 1; // Fallback sur l'ID 1 pour les tests locaux

        // 1. REQUÊTES SQL DYNAMIQUES (Agrégation en temps réel pour tes compteurs)
        $nb_en_attente = DB::table('demandes')->where('id_relais', $id_relais)->where('statut', 'Reçu')->count();
        $nb_approuves  = DB::table('demandes')->where('id_relais', $id_relais)->where('statut', 'Signé & Archivé')->count();
        $nb_en_cours   = DB::table('demandes')->where('id_relais', $id_relais)->where('statut', 'En cours')->count();

        // 2. RÉCUPÉRATION DES 5 DERNIERS DOSSIERS SUBMIS (Normalisation 3NF avec Jointure Citoyen)
        $dernieres_demandes = DB::table('demandes')
            ->join('citoyens', 'demandes.id_citoyen', '=', 'citoyens.id_citoyen')
            ->where('demandes.id_relais', $id_relais)
            ->select('citoyens.nom', 'citoyens.prenom', 'demandes.type_acte', 'demandes.statut', 'demandes.date_creation')
            ->orderBy('demandes.date_creation', 'desc')
            ->limit(5)
            ->get();

        // 3. ENVOI DES VRAIES DONNÉES À LA VUE DE PENDA
        return view('relais.dashboard', compact('nb_en_attente', 'nb_approuves', 'nb_en_cours', 'dernieres_demandes'));
    }
}

