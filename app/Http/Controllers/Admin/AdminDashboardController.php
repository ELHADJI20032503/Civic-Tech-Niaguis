<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    // Météorologie des notifications pour la barre latérale
    private function getNbEnAttente() {
        return DB::table('demandes')->where('statut', 'Reçu')->count();
    }

    // 1. VUE D'ENSEMBLE (TABLEAU DE BORD PRINCIPAL)
    public function index()
    {
        $total_utilisateurs = DB::table('utilisateurs')->count();
        $total_demandes     = DB::table('demandes')->count();
        $nb_en_attente      = $this->getNbEnAttente();
        
        // Comptage strict basé uniquement sur ta vraie colonne 'role'
        $nb_relais    = DB::table('utilisateurs')->where('role', 'Relais')->count();
        $nb_officiers = DB::table('utilisateurs')->where('role', 'Mairie')->count();

        return view('admin.dashboard', compact(
            'total_utilisateurs', 'total_demandes', 'nb_en_attente', 'nb_relais', 'nb_officiers'
        ));
    }

    // 2. GESTION DES AGENTS (INSCRIPTION / LISTE)
    public function agents()
    {
        $nb_en_attente = $this->getNbEnAttente();
        $utilisateurs = DB::table('utilisateurs')->orderBy('nom', 'asc')->get();
        return view('admin.agents', compact('nb_en_attente', 'utilisateurs'));
    }

    // 3. CRÉATION RAPIDE D'UN AGENT (RELAIS OU MAIRIE)
        public function storeAgent(Request $request)
    {
        // RECTIFICATION : Aligner la règle unique sur ta colonne réelle 'login'
        $request->validate([
            'login'    => 'required|string|max:255|unique:utilisateurs,login', // Correction de la colonne
            'password' => 'required|string|min:4',
            'prenom'   => 'required|string|max:255',
            'nom'      => 'required|string|max:255',
            'role'     => 'required|string|in:admin,mairie,relais',
        ]);

        // Suite de ton code pour l'insertion de l'agent...
        DB::table('utilisateurs')->insert([
            'login'         => $request->input('login'),
            'password_hash' => password_hash($request->input('password'), PASSWORD_BCRYPT),
            'prenom'        => $request->input('prenom'),
            'nom'           => $request->input('nom'),
            'role'          => $request->input('role'),
            'statut_compte' => 'actif',
            'created_at'    => now()
        ]);

        return redirect()->route('admin.agents')->with('success', 'L\'agent municipal a été créé avec succès.');
    }


    // 4. STATISTIQUES AVANCÉES
    public function statistiques()
    {
        $nb_en_attente = $this->getNbEnAttente();
        $naissances = DB::table('demandes')->where('type_acte', 'Naissance')->count();
        $mariages   = DB::table('demandes')->where('type_acte', 'Mariage')->count();
        $deces      = DB::table('demandes')->where('type_acte', 'Décès')->count();
        return view('admin.statistiques', compact('nb_en_attente', 'naissances', 'mariages', 'deces'));
    }

    // 5. RAPPORT COMPTABLE
    public function rapports()
    {
        $nb_en_attente = $this->getNbEnAttente();
        $total_recettes = DB::table('demandes')->where('statut', 'Signé & Archivé')->count() * 1000;
        return view('admin.rapports', compact('nb_en_attente', 'total_recettes'));
    }

    // 6. CONFIGURATION CORE
    public function configuration()
    {
        $nb_en_attente = $this->getNbEnAttente();
        return view('admin.configuration', compact('nb_en_attente'));
    }
}
