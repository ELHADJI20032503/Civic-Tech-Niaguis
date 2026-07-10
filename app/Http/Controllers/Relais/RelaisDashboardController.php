<?php

namespace App\Http\Controllers\Relais;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RelaisDashboardController extends Controller
{
    // 1. AFFICHAGE DU TABLEAU DE BORD (HISTORIQUE DES SAISIES)
        // 1. AFFICHAGE DU TABLEAU DE BORD (HISTORIQUE DES SAISIES)
        // 1. AFFICHAGE DU TABLEAU DE BORD (HISTORIQUE DES SAISIES)
        // 1. AFFICHAGE DU TABLEAU DE BORD (HISTORIQUE DES SAISIES)
        // 1. AFFICHAGE DU TABLEAU DE BORD (HISTORIQUE DES SAISIES)
        // 1. AFFICHAGE DU TABLEAU DE BORD (HISTORIQUE DES SAISIES AVEC JOINTURE CITOYENS)
    public function index()
    {
        $idRelaisSession = session('user_id') ?? session('auth_user_id') ?? 1;

        // EXTRACTION COMPLÈTE AVEC JOINTURE POUR COMPLÉTER LES PROPRIÉTÉS $prenom ET $nom
        $historique = DB::table('demandes')
            ->join('citoyens', 'demandes.id_citoyen', '=', 'citoyens.id_citoyen')
            ->select('demandes.*', 'citoyens.prenom', 'citoyens.nom')
            ->where('demandes.id_relais', $idRelaisSession)
            ->orderBy('demandes.id_demande', 'desc')
            ->get();

        // 1. Calcul des actes en attente (Statut 'Reçu')
        $nb_en_attente = DB::table('demandes')->where('statut', 'Reçu')->count();

        // 2. Calcul des actes approuvés (Statut 'Signé & Archivé')
        $nb_approuves = DB::table('demandes')->where('statut', 'Signé & Archivé')->count();

        // 3. Calcul des actes en cours (Statut 'Prêt')
        $nb_en_cours = DB::table('demandes')->where('statut', 'Prêt')->count();

        // Assigner l'historique joint à la variable attendue par ton tableau HTML
        $dernieres_demandes = $historique;

        // Envoi complet de toutes les clés d'affichage requises pour bétonner la sécurité
        return view('relais.dashboard', compact(
            'historique', 
            'dernieres_demandes', 
            'nb_en_attente', 
            'nb_approuves', 
            'nb_en_cours'
        ));
    }






    public function choix_acte()
    {
        return view('relais.choix_acte');
    }

    public function create()
    {
        return view('relais.nouvelle-demande-naissance');
    }

    public function create_mariage()
    {
        return view('relais.nouvelle-demande-mariage');
    }

    public function create_deces()
    {
        return view('relais.nouvelle-demande-deces');
    }

    // 2. ENREGISTREMENT D'UNE NAISSANCE
    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'date_naissance' => 'required|date',
            'heure_naissance' => 'required',
            'lieu_naissance' => 'required|string|max:150',
            'genre' => 'required|string|in:M,F',
            'prenom_pere' => 'nullable|string|max:100',
            'prenom_mere' => 'required|string|max:100',
            'nom_mere' => 'required|string|max:100',
            'certificat_hopital' => 'required|file|mimes:pdf,jpeg,png,jpg|max:5120',
        ]);

        $filePath = null;
        if ($request->hasFile('certificat_hopital')) {
            $filePath = $request->file('certificat_hopital')->store('certificats', 'public');
        }

        $idRelaisSession = session('user_id') ?? session('auth_user_id') ?? 1;

        DB::transaction(function () use ($data, $filePath, $idRelaisSession) {
            $id_citoyen = DB::table('citoyens')->insertGetId([
                'nom' => $data['nom'],
                'prenom' => $data['prenom'],
                'date_naissance' => $data['date_naissance'],
                'lieu_naissance' => $data['lieu_naissance'],
                'genre' => $data['genre'],
            ]);

            // RECTIFICATION : Suppression de 'created_at' pour correspondre à MySQL
            $id_demande = DB::table('demandes')->insertGetId([
                'numero_suivi' => 'ACT-' . strtoupper(\Illuminate\Support\Str::random(8)),
                'type_acte' => 'Naissance',
                'id_citoyen' => $id_citoyen,
                'id_relais' => $idRelaisSession,
                'statut' => 'Reçu',
            ]);

            DB::table('details_naissances')->insert([
                'id_demande'      => $id_demande,
                'prenom_pere'     => $data['prenom_pere'],
                'nom_pere'        => $data['nom'], 
                'prenom_mere'     => $data['prenom_mere'],
                'nom_mere'        => $data['nom_mere'],
                'village_origine' => $data['lieu_naissance'] 
            ]);
        });

        return redirect()->route('relais.dashboard')->with('success', 'Déclaration de naissance enregistrée.');
    }

    // 3. ENREGISTREMENT D'UN MARIAGE
    public function store_mariage(Request $request)
    {
        $data = $request->validate([
            'nom_c1' => 'required|string|max:100',
            'prenom_c1' => 'required|string|max:100',
            'cni_conjoint_1' => 'required|string|max:50',
            'nom_c2' => 'required|string|max:100',
            'prenom_c2' => 'required|string|max:100',
            'cni_conjoint_2' => 'required|string|max:50',
            'date_mariage' => 'required|date',
            'heure_celebration' => 'required',
            'coutume_mariage' => 'required|string|max:100',
            'identite_temoins' => 'required|string',
            'certificat_mariage' => 'required|file|mimes:pdf,jpeg,png,jpg|max:5120',
        ]);

        $filePath = null;
        if ($request->hasFile('certificat_mariage')) {
            $filePath = $request->file('certificat_mariage')->store('certificats_mariages', 'public');
        }

        $idRelaisSession = session('user_id') ?? session('auth_user_id') ?? 1;

        DB::transaction(function () use ($data, $filePath, $idRelaisSession) {
            $id_c1 = DB::table('citoyens')->insertGetId([
                'nom' => $data['nom_c1'],
                'prenom' => $data['prenom_c1'],
                'date_naissance' => $data['date_mariage'],
                'lieu_naissance' => 'Inconnu',
                'genre' => 'M'
            ]);

            $id_c2 = DB::table('citoyens')->insertGetId([
                'nom' => $data['nom_c2'],
                'prenom' => $data['prenom_c2'],
                'date_naissance' => $data['date_mariage'],
                'lieu_naissance' => 'Inconnu',
                'genre' => 'F'
            ]);
            
            // RECTIFICATION : Suppression de 'created_at' pour correspondre à MySQL
            $id_demande = DB::table('demandes')->insertGetId([
                'numero_suivi' => 'MAR-' . strtoupper(\Illuminate\Support\Str::random(8)),
                'type_acte' => 'Mariage',
                'id_citoyen' => $id_c1,
                'id_relais' => $idRelaisSession,
                'statut' => 'Reçu',
            ]);

            DB::table('details_mariages')->insert([
                'id_demande'      => $id_demande,
                'id_conjoint_1'   => $id_c1,
                'id_conjoint_2'   => $id_c2,
                'coutume_mariage' => $data['coutume_mariage'],
                'identite_temoins'=> $data['identite_temoins']
            ]);
        });

        return redirect()->route('relais.dashboard')->with('success', 'Déclaration de mariage enregistrée.');
    }

    // 4. ENREGISTREMENT D'UN DÉCÈS
    public function store_deces(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'profession_defunt' => 'nullable|string|max:100',
            'date_deces' => 'required|date',
            'lieu_deces' => 'required|string|max:150',
            'prenom_declarant' => 'required|string|max:100',
            'nom_declarant' => 'required|string|max:100',
            'cni_declarant' => 'required|string|max:50',
            'profession_declarant' => 'required|string|max:100',
            'adresse_declarant' => 'required|string|max:150',
            'certificat_deces' => 'required|file|mimes:pdf,jpeg,png,jpg|max:5120',
            'heure_deces' => 'required',
        ]);

        $filePath = null;
        if ($request->hasFile('certificat_deces')) {
            $filePath = $request->file('certificat_deces')->store('certificats_deces', 'public');
        }

        $idRelaisSession = session('user_id') ?? session('auth_user_id') ?? 1;

        DB::transaction(function () use ($data, $filePath, $idRelaisSession) {
            $id_citoyen = DB::table('citoyens')->insertGetId([
                'nom' => $data['nom'],
                'prenom' => $data['prenom'],
                'date_naissance' => now(),
                'lieu_naissance' => 'Inconnu',
                'genre' => 'M'
            ]);
            
            // RECTIFICATION : Suppression de 'created_at' pour correspondre à MySQL
            $id_demande = DB::table('demandes')->insertGetId([
                'numero_suivi' => 'DEC-' . strtoupper(\Illuminate\Support\Str::random(8)),
                'type_acte' => 'Décès',
                'id_citoyen' => $id_citoyen,
                'id_relais' => $idRelaisSession,
                'statut' => 'Reçu',
            ]);

            $declarantFullname = $data['prenom_declarant'] . ' ' . $data['nom_declarant'];

            DB::table('details_deces')->insert([
                'id_demande'         => $id_demande,
                'date_deces'         => $data['date_deces'],
                'lieu_deces'         => $data['lieu_deces'],
                'identite_declarant' => $declarantFullname
            ]);
        });

        return redirect()->route('relais.dashboard')->with('success', 'Déclaration de décès enregistrée.');
    }
}
