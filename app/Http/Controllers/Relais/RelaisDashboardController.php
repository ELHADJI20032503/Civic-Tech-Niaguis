<?php

namespace App\Http\Controllers\Relais;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RelaisDashboardController extends Controller
{
    // 1. AFFICHAGE DU TABLEAU DE BORD MOBILE (DYNAMIQUE)
        public function index()
    {
        // Extraction de l'ID depuis la session Laravel ou fallback sur 1 (Aminata Sall) si non connecté
        $id_relais = session('user_id') ?? 1; 

        // 1. REQUÊTES SQL DYNAMIQUES (Agrégation sur tes tables réelles)
        $nb_en_attente = DB::table('demandes')->where('id_relais', $id_relais)->where('statut', 'Reçu')->count();
        $nb_approuves  = DB::table('demandes')->where('id_relais', $id_relais)->where('statut', 'Signé & Archivé')->count();
        $nb_en_cours   = DB::table('demandes')->where('id_relais', $id_relais)->where('statut', 'Prêt')->count();

        // 2. RÉCUPÉRATION DES 5 DERNIERS DOSSIERS SUBMIS (Jointure 3NF)
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


    // 2. PAGE INTERMÉDIAIRE DE SÉLECTION DU TYPE D'ACTE
    public function choix_acte()
    {
        return view('relais.choix_acte');
    }

    // 3. AFFICHAGE DES FORMULAIRES DE SAISIE
    public function create()
    {
        return view('relais.create_naissance');
    }

    public function create_mariage()
    {
        return view('relais.create_mariage');
    }

    public function create_deces()
    {
        return view('relais.create_deces');
    }

    public function store(Request $request)
{
    // 1. Validation intégrant le fichier d'authentification de l'hôpital et l'heure
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

    // 2. Traitement de l'upload du certificat
    $filePath = null;
    if ($request->hasFile('certificat_hopital')) {
        // Enregistre le fichier localement dans storage/app/public/certificats
        $filePath = $request->file('certificat_hopital')->store('certificats', 'public');
    }

    // 3. Persistance Transactionnelle (NF-02)
    DB::transaction(function () use ($data, $filePath) {
        $id_citoyen = DB::table('citoyens')->insertGetId([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'date_naissance' => $data['date_naissance'],
            'lieu_naissance' => $data['lieu_naissance'],
            'genre' => $data['genre'],
        ]);

        $id_demande = DB::table('demandes')->insertGetId([
            'numero_suivi' => 'ACT-' . strtoupper(Str::random(8)),
            'type_acte' => 'Naissance',
            'id_citoyen' => $id_citoyen,
            'id_relais' => Auth::id() ?? 1,
            'statut' => 'Reçu',
        ]);

                  // Récupération automatique de la clé primaire de la demande insérée juste au-dessus
        $idDemandeDeduite = DB::getPdo()->lastInsertId();

        // RECTIFICATION : Utilisation de la fonction globale request() pour interdire le bug de variable
        DB::table('details_naissances')->insert([
            'id_demande'      => $idDemandeDeduite,
            'prenom_pere'     => request('prenom_pere'),
            'nom_pere'        => request('nom_enfant') ?? request('nom'), 
            'prenom_mere'     => request('prenom_mere'),
            'nom_mere'        => request('nom_mere'),
            'village_origine' => request('lieu_naissance') 
        ]);



    });

    return redirect()->route('relais.dashboard');
}


    // 5. INSERTION TRANSACTIONNELLE : ACTE DE MARIAGE (3NF)
   public function store_mariage(Request $request)
{
    // 1. Validation complète
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

    // 2. Stockage de la preuve
    $filePath = null;
    if ($request->hasFile('certificat_mariage')) {
        $filePath = $request->file('certificat_mariage')->store('certificats_mariages', 'public');
    }

    // 3. Persistance Double Couche 3NF
    DB::transaction(function () use ($data, $filePath) {
        // Enregistrement de l'Époux
        $id_c1 = DB::table('citoyens')->insertGetId([
            'nom' => $data['nom_c1'],
            'prenom' => $data['prenom_c1'],
            'date_naissance' => $data['date_mariage'], // Valeur temporaire d'audit
            'lieu_naissance' => 'Inconnu',
            'genre' => 'M'
        ]);

        // Enregistrement de l'Épouse
        $id_c2 = DB::table('citoyens')->insertGetId([
            'nom' => $data['nom_c2'],
            'prenom' => $data['prenom_c2'],
            'date_naissance' => $data['date_mariage'],
            'lieu_naissance' => 'Inconnu',
            'genre' => 'F'
        ]);
        
        // Enregistrement de la demande Mère
        $id_demande = DB::table('demandes')->insertGetId([
            'numero_suivi' => 'MAR-' . strtoupper(Str::random(8)),
            'type_acte' => 'Mariage',
            'id_citoyen' => $id_c1, // Pivot sur le conjoint principal
            'id_relais' => Auth::id() ?? 1,
            'statut' => 'Reçu'
        ]);

               
               // Récupération universelle des clés primaires générées pour la demande et les conjoints
        $idDemandeDeduite = DB::getPdo()->lastInsertId();
        
        // Déduction mathématique stricte des ID des deux citoyens insérés consécutivement
        $idEpouseDeduite = DB::table('citoyens')->max('id_citoyen') ?? DB::table('citoyens')->max('id');
        $idEpouxDeduite  = $idEpouseDeduite - 1;

        // RECTIFICATION FINALE : Retrait des colonnes de CNI inexistantes dans MySQL
        DB::table('details_mariages')->insert([
            'id_demande'      => $idDemandeDeduite,
            'id_conjoint_1'   => $idEpouxDeduite,   
            'id_conjoint_2'   => $idEpouseDeduite,  
            'coutume_mariage' => request('coutume_mariage'),
            'identite_temoins'=> request('identite_temoins')
            // Les CNI et fichiers sont traités par le protocole HTTP mais exclus de cette table SQL
        ]);



    });

    return redirect()->route('relais.dashboard');
}

    // 6. INSERTION TRANSACTIONNELLE : ACTE DE DÉCÈS (3NF)
    public function store_deces(Request $request)
{
    // 1. Validation stricte du formulaire conforme à la réglementation
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

    // 2. Traitement de l'upload sécurisé
    $filePath = null;
    if ($request->hasFile('certificat_deces')) {
        $filePath = $request->file('certificat_deces')->store('certificats_deces', 'public');
    }

    // 3. Persistance Double Couche 3NF (NF-02)
    DB::transaction(function () use ($data, $filePath) {
        // a. Enregistrement du défunt dans la table Citoyens
        $id_citoyen = DB::table('citoyens')->insertGetId([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'date_naissance' => now(), // Date générique par défaut en 3NF pour le défunt
            'lieu_naissance' => 'Inconnu',
            'genre' => 'M'
        ]);
        
        // b. Enregistrement de la Demande Mère
        $id_demande = DB::table('demandes')->insertGetId([
            'numero_suivi' => 'DEC-' . strtoupper(Str::random(8)),
            'type_acte' => 'Décès',
            'id_citoyen' => $id_citoyen,
            'id_relais' => Auth::id() ?? 1,
            'statut' => 'Reçu'
        ]);

                
                // Récupération universelle de l'ID de la demande insérée juste au-dessus
                // Récupération universelle de l'ID de la demande insérée juste au-dessus
        $idDemandeDeduite = DB::getPdo()->lastInsertId();

        // Concaténation pour remplir le champ obligatoire trouvé dans ton phpMyAdmin
        $declarantFullname = request('prenom_declarant') . ' ' . request('nom_declarant');

        // RECTIFICATION CHIRURGICALE : Injection de la colonne obligatoire identite_declarant
        DB::table('details_deces')->insert([
            'id_demande'         => $idDemandeDeduite,
            'date_deces'         => request('date_deces'),
            'lieu_deces'         => request('lieu_deces'),
            'identite_declarant' => $declarantFullname // Remplit le champ obligatoire pour MySQL
        ]);



    });

    return redirect()->route('relais.dashboard');
}

}